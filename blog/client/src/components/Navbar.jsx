import { React, Component } from "react";
import { mapper } from "./../config/mapper";
import { read } from "./../services/apiReader";
import Spinner from "./Spinner";
import { withRouter } from "react-router-dom";
class Navbar extends Component {
  constructor(props) {
    super(props);
    this.state = {
      configNav: [],
      spinner: false,
    };
  }

  componentDidMount() {
    this.getConfig();
  }

  getConfig() {
    this.setState({ spinner: true });
    read(mapper.getConfig)
      .then((result) => {
        this.setState({
          configNav: result.data,
        });

        setTimeout(() => {
          this.setState({ spinner: false });
        }, 200);
      })
      .catch((error) => {
        console.log(error);
        this.props.history.push("/500");
      });
  }

  render() {
    return (
      <nav
        className="navbar navbar-expand-lg navbar-dark bg-primary fixed-top"
        id="sideNav"
      >
        {this.state.spinner && (
          <Spinner color={"text-light d-block mr-auto spinner-grow"} />
        )}
        <a className="navbar-brand js-scroll-trigger" href="#page-top">
          <span className="d-block d-lg-none font-weight-lighter">
            {!this.state.spinner && this.props.name}
          </span>
          <span className="d-none d-lg-block">
            <img
              className="img-fluid img-profile rounded-circle mx-auto mb-2"
              src={this.props.photo}
              alt={this.props.name}
              title={this.props.email}
            />
          </span>
        </a>
        <button
          className="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span className="navbar-toggler-icon"></span>
        </button>
        <div className="collapse navbar-collapse" id="navbarSupportedContent">
          <ul className="navbar-nav">
            {this.state.configNav.map((item, index) => {
              return (
                <li className="nav-item" key={index}>
                  <a
                    className="nav-link js-scroll-trigger"
                    href={
                      `/#` + item.pageTitle.toLowerCase().replace(/\s/g, "-")
                    }
                    title={item.pageDescription}
                  >
                    {item.pageTitle}
                  </a>
                </li>
              );
            })}
          </ul>
        </div>
      </nav>
    );
  }
}

export default withRouter(Navbar);
