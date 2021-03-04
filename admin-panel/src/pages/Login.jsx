import { Component, React } from "react";
import { accessToken, Token } from "./../services/_index";
import { RouteMapper } from "./../config/_index";
import { withRouter } from "react-router-dom";
import Alert from "../components/Alert";

class Login extends Component {
  constructor(props) {
    super(props);
    this.state = {
      email: "",
      password: "",
    };
  }

  loginUser = () => {
    const { email, password } = this.state;
    accessToken(email, password)
      .then((result) => {
        Token.set(result[1]);
        this.props.history.push(RouteMapper.dashboard);
        Alert("success", "Welcome my friend !");
      })
      .catch((errors) => {
        console.log(errors);
        if (errors[0] !== 500) {
          alert(errors[1].message);
        }
      });
  };

  render() {
    return (
      <div className="row pt-5 pr-4 pl-4">
        <form className="col-12 col-sm-12 col-md-4 col-lg-4 offset-0 offset-sm-0 offset-md-4 offset-lg-4 shadow p-4 rounded">
          <div className="form-group">
            <label>Email address</label>
            <input
              type="email"
              className="form-control"
              onChange={(e) => this.setState({ email: e.target.value })}
              required
            />
          </div>
          <div className="form-group">
            <label>Password</label>
            <input
              type="password"
              className="form-control"
              onChange={(e) => this.setState({ password: e.target.value })}
              required
            />
          </div>
          <button
            type="button"
            className="btn btn-primary"
            onClick={() => this.loginUser()}
          >
            Login
          </button>
        </form>
      </div>
    );
  }
}

export default withRouter(Login);
