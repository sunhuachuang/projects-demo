import React, { Component, PropTypes } from 'react';
import { Link } from 'react-router';

export default class IndexPage extends Component {
  constructor(props) {
    super(props);
    this.handleKeyUp = this.handleKeyUp.bind(this);
    this.handleGoClick = this.handleGoClick.bind(this);
  }

  getInputValue() {
    return this.refs.input.value;
  }

  handleKeyUp(e) {
    if (e.keyCode === 13) {
      this.handleGoClick();
    }
  }

  handleGoClick() {
    this.props.onChange(this.getInputValue());
  }

  render() {
    return (
      <div className="container">
        <input type="text"
               ref="input" className="form-control" onKeyUp={this.handleKeyUp}  placeholder="请输入书名查询" />
        <button type="button" className="btn btn-info" onClick={this.handleGoClick} >搜索</button>
        <div>
          <Link to="/books"><button type="button" className="btn btn-success">books</button></Link>
          <button type="button" className="btn btn-info">login</button>
        </div>
      </div>
    );
  }
}

IndexPage.propTypes = {
  onChange: PropTypes.func.isRequired
};
