from flask import Flask
from .admin import create_admin
from .models import db, cache
from flask.ext.login import LoginManager

__version__ = '0.1'
__status__ = 'dev'
__description__ = 'Simple shopsite system powered by Flask'
__author__ = 'huachuang'
__email__ = 'huachuang20@gmail.com'
__license__ = "MIT License"

def create_app():
    app = Flask(__name__, instance_relative_config=True)

    app.config.from_object('config')
    app.config.from_pyfile('config.py')

    register_database(app)
    register_blueprint(app)
    init_login(app)
    create_admin(app, db)

    return app

def register_log():
    import logging
    logging.basicConfig()
    logging.getLogger().setLevel(logging.DEBUG)

def register_database(app):
    db.init_app(app)
    db.app = app
    cache.init_app(app)

def register_blueprint(app):
    from app.core.views import bp
    app.register_blueprint(bp)
    from app.core.api import api
    app.register_blueprint(api, url_prefix='/api')

def init_login(app):
    login_manager = LoginManager()
    login_manager.init_app(app)

    # Create user loader function
    @login_manager.user_loader
    def load_user(user_id):
        from .models import User
        return db.session.query(User).get(user_id)
