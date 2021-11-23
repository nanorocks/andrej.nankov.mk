import { React, Component } from "react";

class Summary extends Component {
  render() {
    return (
      <section className="resume-section" id="summary">
        {!this.props.spinner && (
          <div className="resume-section-content">
            <h2 className="mb-5">Summary</h2>
            <div className="subheading mb-3">Education and Experience</div>
            <p
              className="text-justify"
              dangerouslySetInnerHTML={{ __html: this.props.summary }}
            ></p>
            <div className="subheading mb-3">Current area of work</div>
            <p
              className="mb-3 text-justify"
              dangerouslySetInnerHTML={{ __html: this.props.currentWork }}
            ></p>
            <div>
              <div className="resume-section-content">
                {this.props.topProgrammingLanguages.length !== 0 && (
                  <div>
                    <div className="subheading mb-3">
                      Programming Languages / Tools / Frameworks
                    </div>
                    <ul className="list-inline dev-icons">
                      {this.props.topProgrammingLanguages
                        .split(";")
                        .map((pl, index) => {
                          return (
                            <li
                              key={index}
                              className="list-inline-item"
                              data-toggle="tooltip"
                              data-placement="bottom"
                              title={pl
                                .replace("fab fa-", "")
                                .replace("fa fa-", "")}
                            >
                              <i className={pl}></i>
                            </li>
                          );
                        })}
                    </ul>
                  </div>
                )}
                <div className="subheading mb-3">Goals</div>
                <ul className="fa-ul mb-0">
                  {this.props.goals.split(";").map((goal, index) => {
                    return (
                      <li key={index}>
                        <span className="fa-li">
                          <i className="fas fa-check"></i>
                        </span>
                        {goal}
                      </li>
                    );
                  })}
                </ul>
              </div>
            </div>
          </div>
        )}
      </section>
    );
  }
}

export default Summary;
