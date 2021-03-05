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
        Alert("dark", "Welcome my friend !");
      })
      .catch((errors) => {
        if (errors[0] !== 500) {
          Alert("error", errors[1].message);
        }
      });
  };

  render() {
    return (
      <div className="container">
        <div className="row pt-5 mt-5">
          <form className="col-12 col-sm-12 col-md-4 col-lg-4 offset-0 offset-sm-0 offset-md-4 offset-lg-4 shadow-lg pl-4 pr-4 rounded-lg pt-5">
            <hr />
            <p className="text-center h2 font-weight-bolder pb-4 text-capitalize">
              Admin
              <span className="text-danger"> panel</span>
              <hr />
            </p>
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
              className="btn btn-danger  btn-lg btn-block rounded-pill mt-4 font-weight-bolder text-capitalize"
              onClick={() => this.loginUser()}
            >
              Login
            </button>
            <p className="small text-muted font-italic text-right text-capitalize mt-5">
              personal website
            </p>
          </form>
        </div>
      </div>
    );
  }
}

export default withRouter(Login);
