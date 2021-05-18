import { React, Component } from "react";

class Highlights extends Component {
  render() {
    return (
      <section className="resume-section" id="highlights">
        <div className="resume-section-content">
          <h2 className="mb-5">Highlights</h2>
          {this.props.highlights.length === 0 ? (
            "No published highlights yet."
          ) : (
            <div
              dangerouslySetInnerHTML={{ __html: this.props.highlights }}
            ></div>
          )}
        </div>
      </section>
    );
  }
}

export default Highlights;
