import React, { Component, PropTypes } from 'react';
import { connect } from 'react-redux';
import { push } from 'react-router-redux';

class Search extends Component {
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

Search.propTypes = {
  push: PropTypes.func.isRequired
  // Injected by React Router
};

export default connect({
  push
})(Search);
