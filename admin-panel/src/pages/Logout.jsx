import { Component } from "react";
import { Token } from "../services/_index";
import { RouteMapper } from "../config/_index";
import { withRouter } from "react-router-dom";
import Alert from "../components/Alert";

class Logout extends Component {
  componentDidMount(){
    Alert("info", "Bye Bye !!!");
  }
  render() {
    Token.clear();
    this.props.history.push(RouteMapper.login);
    return null;
  }
}

export default withRouter(Logout);
