import { Component, React } from "react";
import { accessToken } from "./../services/_index";
import { RouteMapper } from "./../config/_index";
import { withRouter } from "react-router-dom";
import Alert from "../components/Alert";
import Spinner from "../components/Spinner";
import ReCAPTCHA from "react-google-recaptcha";
import ErrorsHandler from "../components/ErrorsHandler";

class Login extends Component {
  constructor(props) {
    super(props);
    this.state = {
      email: "",
      password: "",
      reCaptcha: "",
      spinner: false,
      errors: [],
    };
  }

  loginUser = () => {
    this.setState({ spinner: true });
    const { email, password, reCaptcha } = this.state;
    accessToken({ email, password, reCaptcha })
      .then((result) => {
        this.setState({ spinner: false });
        this.props.history.push(RouteMapper.dashboard);
        Alert("dark", "Welcome my friend !");
      })
      .catch((errors) => {
        if (errors[0] === 422) {
          this.setState({ errors: errors[1], spinner: false });
          return;
        }
        if (errors[0] !== 500) {
          Alert("error", errors[1].message);
        }
      });
  };

  render() {
    return (
      <div className="container">
        <div className="row pt-5 mt-5">
          <form className="col-md-6 offset-md-3 shadow-lg border pl-4 pr-4 rounded-lg pt-5">
            <hr />
            <div className="text-center h2 font-weight-bolder pb-4 text-capitalize">
              Admin
              <span className="text-danger"> panel</span>
              <hr />
            </div>
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
            <ReCAPTCHA
              sitekey="6LcPqb4aAAAAAAFa3BzIAfLvBGytDK76h38A2wXi"
              onChange={(value) => this.setState({ reCaptcha: value })}
            />
            <ErrorsHandler errors={this.state.errors} />
            <button
              type="button"
              className="p-3 btn btn-danger  btn-lg btn-block rounded-pill mt-4 font-weight-bolder text-capitalize"
              onClick={() => this.loginUser()}
            >
              {this.state.spinner && <Spinner size="sm" />} Login
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
