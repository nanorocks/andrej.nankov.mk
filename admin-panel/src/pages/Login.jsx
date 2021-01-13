import { Component, React } from "react";

class Login extends Component {
  render() {
    return (
      <div className="row pt-5 pr-4 pl-4">
        <form className="col-12 col-sm-12 col-md-4 col-lg-4 offset-0 offset-sm-0 offset-md-4 offset-lg-4 shadow p-4 rounded">
          <div className="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" className="form-control" />
            <small className="form-text text-muted">We'll never share your email with anyone else.</small>
          </div>
          <div className="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" className="form-control" />
          </div>
          <div className="form-group form-check">
            <input type="checkbox" className="form-check-input" />
            <label className="form-check-label" for="exampleCheck1">Check me out</label>
          </div>
          <button type="submit" className="btn btn-primary">Submit</button>
        </form>
      </div>
    );
  }
}

export default Login;
