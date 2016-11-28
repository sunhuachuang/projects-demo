import React, { Component, PropTypes } from 'react';
import { connect } from 'react-redux';
import { push } from 'react-router-redux';

class Book extends Component {
  constructor(props) {
    super(props);
    this.handleChange = this.handleChange.bind(this);
  }

  handleChange(value) {
    this.props.push(`/books/s/${value}`);
  }

  render() {
    return (
      <div>
        aa
      </div>
    );
  }
}

Book.propTypes = {
  push: PropTypes.func.isRequired
};

export default connect({
  push
})(Book);
