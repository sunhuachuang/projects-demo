# shumeng-frontend
webapp build by redux and react.

Route:

index:  /
books:  /books
book:   /books/id
search: /books/s/value
carts:  /carts
user:   /users/id
orders: /users/id/orders
order:  /users/id/orders/id

store:
{
  auth: {},//个人信息，包括个人信息里面的orders
  carts: {},//购物车
  books://书本合集
  {
    hot: {},//热销书本，出现在books首页
    new: {},//最新书本，出现在books首页
    category: {},//按目录查找的书本合集
    search: {},//搜索出来的书本合集
  },
  book: {},//书本详情页
}
