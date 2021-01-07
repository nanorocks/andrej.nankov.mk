import { React, Component } from "react";

class Highlights extends Component {
  render() {
    return (
      <section className="resume-section" id="highlights">
        <div className="resume-section-content">
          <h2 className="mb-5">Highlights</h2>
          {this.props.highlightsKeys.map((year, index) => {
            return (
              <div key={index}>
                <h3 className="mb-2">{year}</h3>
                <ul className="fa-ul mb-0">
                  {this.props.highlightsValues[index].map(
                    (highlights, index1) => {
                      return (
                        <li key={index1}>
                          <span className="fa-li">
                            <i className="fas fa-trophy text-warning"></i>
                          </span>
                          {highlights}
                        </li>
                      );
                    }
                  )}
                </ul>
              </div>
            );
          })}
        </div>
      </section>
    );
  }
}

export default Highlights;
