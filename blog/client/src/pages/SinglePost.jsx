import { React, Component } from "react";
import { Navbar } from "./../components/_index";
import { Fade } from "react-awesome-reveal";
import { withRouter } from "react-router-dom";

class SinglePost extends Component {
  constructor(props) {
    super(props);
  }

  render() {
    return (
      <div>
        <Navbar name={`Post title`}></Navbar>
          <section className="resume-section" id="summary">
            <div className="resume-section-content">
              <h2 className="mb-5">Summary</h2>
              <div className="subheading mb-3">Education and Experience</div>
              <div className="subheading mb-3">Current area of work</div>
              <p className="mb-3"></p>
                <div className="resume-section-content">
                  <div className="subheading mb-3">
                    Programming Languages / Tools / Frameworks
                  </div>
                  <ul className="list-inline dev-icons">
                   
                  </ul>
                  <div className="subheading mb-3">Goals</div>
                  <ul className="fa-ul mb-0">
                  </ul>
                </div>
            </div>
          </section>
      </div>
    );
  }
}

export default withRouter(SinglePost);
