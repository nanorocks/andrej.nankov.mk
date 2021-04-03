import { React, Component } from "react";
import { Link } from "react-router-dom";

class ErrorPage extends Component {
  render() {
    return (
      <div id="error" className="container shadow-lg p-5 mt-5 rounded-lg">
        <div className="error mt-5">
          <div className="error-code">
            <h1 className="display-1">
               Oops!
            </h1>
            <p className="h3 font-weight-100">
              {this.props.title} | {this.props.description}
            </p>
          </div>
          <Link to={"/"} className="btn btn-danger btn-lg rounded-pill mt-4">
            Go Back
          </Link>
        </div>
      </div>
    );
  }
}

export default ErrorPage;
