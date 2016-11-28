import logging
import os.path
import uuid
import tornado.httpserver
import tornado.ioloop
import tornado.options
import tornado.web
import tornado.websocket
import json


def is_json(myjson):
    try:
        json_object = json.loads(myjson)
    except ValueError:
        return False
    return json_object

def send_message(message):
    for name, handler in ChatSocketHandler.socket_handlers.items():
        try:
            handler.write_message(message)
        except:
            logging.error('Error sending message', exc_info=True)

class TestHandler(tornado.web.RequestHandler):
    def get(self):
        self.render('test.html')


class ChatHandler(tornado.web.RequestHandler):
    names = set()
    def post(self):
        name = self.get_argument("name")
        if not name or name in ChatHandler.names:
            return self.render('index.html', error='exist name!')
        ChatHandler.names.add(name)
        print(name)
        self.render('chat.html', names=ChatHandler.names, name=name)

class MainHandler(tornado.web.RequestHandler):
    def get(self):
        self.render('index.html', error='')

class OneToOneHandler(tornado.web.RequestHandler):
    def get(self):
        room_name = self.get_argument('room-name')
        name = self.get_argument('name')
        self.render('o2o.html', room_name=room_name, name=name)

class OneToOneChatSocketHandler(tornado.websocket.WebSocketHandler):
    room_names = {} # {'room_name': [one_clinet, other_client]}

    def check_origin(self, origin):
        return True

    def open(self):
        room_name = self.get_argument('room-name')
        if room_name in OneToOneChatSocketHandler.room_names:
            if OneToOneChatSocketHandler.room_names[room_name][1]:
                self.write_message('sorry, this room has used, go back to recome!!!')
                return None
            OneToOneChatSocketHandler.room_names[room_name][1] = self
            for client in OneToOneChatSocketHandler.room_names[room_name]:
                client.write_message('into single room:'+room_name)
        else:
            OneToOneChatSocketHandler.room_names[room_name] = [self, None]
            self.write_message('into single room:'+room_name)

    def on_close(self):
        room_name = self.get_argument('room-name')
        if room_name in OneToOneChatSocketHandler.room_names:
            OneToOneChatSocketHandler.room_names[room_name].remove(self)
            if not OneToOneChatSocketHandler.room_names[room_name]:
                del OneToOneChatSocketHandler.room_names[room_name]
                return None
            for client in OneToOneChatSocketHandler.room_names[room_name]:
                if client:
                    client.write_message('other out room.')

    def on_message(self, message):
        room_name = self.get_argument('room-name')
        if room_name in OneToOneChatSocketHandler.room_names:
            for client in OneToOneChatSocketHandler.room_names[room_name]:
                if client:
                    client.write_message(message)

class ChatSocketHandler(tornado.websocket.WebSocketHandler):
    socket_handlers = {}
    isVideo = False

    def check_origin(self, origin):
        return True

    def open(self):
        name = self.get_argument("name")
        if (ChatSocketHandler.isVideo):
            self_data = {'event': 'is-videoing'}
            self.write_message(json.dumps(self_data))

        data = {'event': 'user-in', 'data': name}
        send_message(json.dumps(data))
        ChatSocketHandler.socket_handlers[name] = self

    def on_close(self):
        close_name = self.get_argument("name")
        del ChatSocketHandler.socket_handlers[close_name]
        ChatHandler.names.remove(close_name)
        data = {'event': 'user-out', 'data': close_name}
        send_message(json.dumps(data))

    def on_message(self, message):
        data = is_json(message)
        if data:
            if data['event'] == 'chat-single' and ChatSocketHandler.socket_handlers[data['resName']]:
                res_data = {'event': 'chat-single', 'reqName': data['reqName'], 'roomName': data['roomName']}
                ChatSocketHandler.socket_handlers[data['resName']].write_message(json.dumps(res_data))
                return None
            if (data['event'] == 'start-video'):
                ChatSocketHandler.isVideo = True
        send_message(message)

def main():
    settings = {
        'template_path': os.path.join(os.path.dirname(__file__), 'templates'),
        'static_path': os.path.join(os.path.dirname(__file__), 'static')
    }

    application = tornado.web.Application([
        (r'/', MainHandler),
        (r'/test', TestHandler),
        (r'/chat', ChatHandler),
        (r'/websocket', ChatSocketHandler),
        (r'/o2o', OneToOneHandler),
        (r'/o2o-socket', OneToOneChatSocketHandler)
    ], **settings)

    server = tornado.httpserver.HTTPServer(application, ssl_options={
        "certfile": os.path.join(os.path.abspath("."), "ssl.crt"),
        "keyfile": os.path.join(os.path.abspath("."), "ssl.key"),
    })

    server.listen(8000)

    print('start tornado! https://localhost:8000')
    tornado.ioloop.IOLoop.instance().start()

if __name__ == '__main__':
    main()
