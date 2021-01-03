import { React, Component } from "react";

class Highlights extends Component {
  constructor(props) {
    super(props);
    this.state = {
      highlightsYear: [],
      highlightsDescription: [],
    };
  }

  componentDidMount() {
    this.setState({ 
      highlightsYear: Object.keys(this.props.highlights) 
    });
    this.setState({
      highlightsDescription: Object.values(this.props.highlights),
    });
  }

  render() {
    return (
      <section className="resume-section" id="highlights">
        <div className="resume-section-content">
          <h2 className="mb-5">Highlights</h2>
          {this.state.highlightsYear.map((year, index) => {
            return (
              <div key={index}>
                <h3 className="mb-2">{year}</h3>
                <ul className="fa-ul mb-0">
                  {this.state.highlightsDescription[index].map(
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
