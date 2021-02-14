import { Component, React } from "react";
import { accessToken, setToken } from "./../services/_index";

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
    accessToken(email, password).then((result) => {
      // console.log(result);
      setToken(result[1]);
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
            />
          </div>
          <div className="form-group">
            <label>Password</label>
            <input
              type="password"
              className="form-control"
              onChange={(e) => this.setState({ password: e.target.value })}
            />
          </div>
          <div className="form-group form-check">
            <input type="checkbox" className="form-check-input" />
            <label className="form-check-label">
              Check me out
            </label>
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

export default Login;
