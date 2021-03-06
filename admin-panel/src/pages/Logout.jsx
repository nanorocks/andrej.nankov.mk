import { Component } from "react";
import { Token } from "../services/_index";
import { RouteMapper } from "../config/_index";
import { Redirect, withRouter } from "react-router-dom";
import Alert from "../components/Alert";

class Logout extends Component {
  componentDidMount(){
    Alert("dark", "Bye Bye !!!");
  }
  render() {
    Token.clear();
    return <Redirect to={RouteMapper.login}></Redirect>;
  }
}

export default withRouter(Logout);
