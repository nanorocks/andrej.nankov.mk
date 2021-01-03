import { React, Component } from "react";

class Summary extends Component {
  state = {};
  constructor(props) {
    super(props);
  }

  render() {
    return (
      <section className="resume-section" id="summary">
        <div className="resume-section-content">
          <h2 className="mb-5">Summary</h2>
          <p>
            Apart from being a web developer, I enjoy most of my time being
            outdoors. In the winter, I am an avid skier and novice ice climber.
            During the warmer months here in Colorado, I enjoy mountain biking,
            free climbing, and kayaking.
          </p>
          <p className="mb-4">
            When forced indoors, I follow a number of sci-fi and fantasy genre
            movies and television shows, I am an aspiring chef, and I spend a
            large amount of my free time exploring the latest technology
            advancements in the front-end web development world.
          </p>
          <p>
            <div className="resume-section-content">
              <div className="subheading mb-3">
                Programming Languages & Tools
              </div>
              <ul className="list-inline dev-icons">
                <li className="list-inline-item">
                  <i className="fab fa-html5"></i>
                </li>
                <li className="list-inline-item">
                  <i className="fab fa-css3-alt"></i>
                </li>
                <li className="list-inline-item">
                  <i className="fab fa-js-square"></i>
                </li>
                <li className="list-inline-item">
                  <i className="fab fa-angular"></i>
                </li>
                <li className="list-inline-item">
                  <i className="fab fa-react"></i>
                </li>
                <li className="list-inline-item">
                  <i className="fab fa-node-js"></i>
                </li>
                <li className="list-inline-item">
                  <i className="fab fa-sass"></i>
                </li>
                <li className="list-inline-item">
                  <i className="fab fa-node"></i>
                </li>
                <li className="list-inline-item">
                  <i className="fab fa-wordpress"></i>
                </li>
                <li className="list-inline-item">
                  <i className="fab fa-gulp"></i>
                </li>
                <li className="list-inline-item">
                  <i className="fab fa-grunt"></i>
                </li>
                <li className="list-inline-item">
                  <i className="fab fa-npm"></i>
                </li>
              </ul>
              <div className="subheading mb-3">Workflow</div>
              <ul className="fa-ul mb-0">
                <li>
                  <span className="fa-li">
                    <i className="fas fa-check"></i>
                  </span>
                  Mobile-First, Responsive Design
                </li>
                <li>
                  <span className="fa-li">
                    <i className="fas fa-check"></i>
                  </span>
                  Cross Browser Testing & Debugging
                </li>
                <li>
                  <span className="fa-li">
                    <i className="fas fa-check"></i>
                  </span>
                  Cross Functional Teams
                </li>
                <li>
                  <span className="fa-li">
                    <i className="fas fa-check"></i>
                  </span>
                  Agile Development & Scrum
                </li>
              </ul>
            </div>
          </p>
        </div>
      </section>
    );
  }
}

export default Summary;
