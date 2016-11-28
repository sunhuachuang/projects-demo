import React, { Component, PropTypes } from 'react';

export default class Header extends Component {
  render() {
    return (
      <div class="page-header">
        <h1>Example page header <small>Subtext for header</small></h1>
      </div>
    );
  }
}

Header.propTypes = {
};
