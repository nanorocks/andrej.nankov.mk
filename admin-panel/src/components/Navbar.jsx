import { Component, React } from "react";
import { Link } from "react-router-dom";

class Navbar extends Component {
  render() {
    return (
      <div>
        <nav className="navbar navbar-expand-lg navbar-dark bg-dark">
          <Link
            className="navbar-brand font-weight-bolder text-capitalize"
            to="/dashboard"
          >
            Admin
            <span className="text-danger"> panel</span>
          </Link>
          <button
            className="navbar-toggler"
            type="button"
            data-toggle="collapse"
            data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown"
            aria-expanded="false"
            aria-label="Toggle navigation"
          >
            <span className="navbar-toggler-icon"></span>
          </button>
          <div className="collapse navbar-collapse" id="navbarNavDropdown">
            <ul className="navbar-nav ml-auto">
              <li className="nav-item">
                <Link className="nav-link" to="/dashboard">
                  Dashboard
                </Link>
              </li>
              <li className="nav-item">
                <Link className="nav-link" to="/configs">
                  Config
                </Link>
              </li>
              <li className="nav-item">
                <Link className="nav-link" to="/posts">
                  Posts
                </Link>
              </li>
              <li className="nav-item">
                <Link className="nav-link" to="/projects">
                  Projects
                </Link>
              </li>
              <li className="nav-item">
                <Link className="nav-link text-light btn btn-danger font-weight-bolder" to="/logout">
                  Logout
                </Link>
              </li>
            </ul>
          </div>
        </nav>
        <div className="small p-1 text-right">
          <p className="small text-muted font-weight-bolder font-italic">
            Before any actions, for first time setup run the Bootstrap seeder.
          </p>
        </div>
      </div>
    );
  }
}

export default Navbar;
