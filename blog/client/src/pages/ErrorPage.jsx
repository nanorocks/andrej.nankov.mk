import { React, Component } from "react";
import { Link } from "react-router-dom";
import { Helmet } from "react-helmet";

class ErrorPage extends Component {
  render() {
    return (
      <div id="error" className="container">
        <Helmet>
          <title>
            {`${this.props.title} - ${this.props.description}`}
          </title>
        </Helmet>
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
