import React, { Component, PropTypes } from 'react';
import { connect } from 'react-redux';
import { push } from 'react-router-redux';
import Footer from '../components/Footer';
import Header from '../components/Header';
import IndexPage from '../components/IndexPage';

class Books extends Component {
  constructor(props) {
    super(props);
    this.handleChange = this.handleChange.bind(this);
  }

  handleChange(value) {
    this.props.push(`/books/s/${value}`);
  }

  render() {
    const { children } = this.props;
    return (
      <div>
        aa
      </div>
    );
  }
}

Books.propTypes = {
  push: PropTypes.func.isRequired,
  // Injected by React Router
  children: PropTypes.node
};

export default connect({
  push
})(Books);
