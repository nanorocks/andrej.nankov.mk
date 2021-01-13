import { React, Component } from "react";
import { Link } from "react-router-dom";

class ErrorPage extends Component {
  render() {
    return (
      <div id="error" className="container">
        <div class="error mt-5">
          <div class="error-code">
            <h1>Oops!</h1>
            <h2>
            {this.props.title} - {this.props.description}
            </h2>
          </div>
          <Link to={"/"} className="btn btn-primary btn-sm">
            Go Back
          </Link>
        </div>
      </div>
    );
  }
}

export default ErrorPage;
