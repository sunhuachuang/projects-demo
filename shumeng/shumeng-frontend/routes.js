import React from 'react';
import { Route } from 'react-router';
import Index from './containers/Index';
import Books from './containers/Books';
import Book from './containers/Book';
import Search from './containers/Search';

export default (
  <Route path="/" component={Index}>
    <Route path="/books" component={Books}>
      <Route path="/:book_id" component={Book} />
      <Route path="/s/:value" component={Search} />
    </Route>
  </Route>
);
