import { React, Component } from "react";

class Welcome extends Component {
 
  constructor(props) {
    super(props);
    this.state = {
      quotes: () => {
        let quotesList = '';
        for (const [key, value] of Object.entries(this.props.quotes)) {
          quotesList += `<strong>${key}: ${value}</strong>`
        }
        return quotesList;
      }
      
    }
  }

  render() {
    return (
      <section className="resume-section" id="welcome">
        <div className="resume-section-content">
          <h1 className="mb-0">
            {this.props.name.split(" ")[0]}
            <span className="text-primary">
              {" "}
              {this.props.name.split(" ")[1]}
            </span>
          </h1>
          <div className="subheading mb-5">
            {this.props.address} · {this.props.phone} ·
            <a href={`mailto:` + this.props.email}>{this.props.email}</a>
          </div>
          <p
            className="lead mb-3"
            dangerouslySetInnerHTML={{ __html: this.props.intro }}
          ></p>
          <p
            className="lead mb-5 font-weight-strong"
            dangerouslySetInnerHTML={{ __html: this.state.quotes() }}
          ></p>
          <div className="social-icons">
            <a
              className="social-icon"
              href={this.props.socMedia.linkedIn}
              target="_blank"
              rel="noreferrer"
            >
              <i className="fab fa-linkedin-in"></i>
            </a>
            <a
              className="social-icon"
              href={this.props.socMedia.github}
              target="_blank"
              rel="noreferrer"
            >
              <i className="fab fa-github"></i>
            </a>
            <a
              className="social-icon"
              href={this.props.socMedia.facebook}
              target="_blank"
              rel="noreferrer"
            >
              <i className="fab fa-facebook-f"></i>
            </a>
            <a
              className="social-icon"
              href={this.props.socMedia.facebook}
              target="_blank"
              rel="noreferrer"
            >
              <i className="fab fa-instagram"></i>
            </a>
          </div>
        </div>
      </section>
    );
  }
}

export default Welcome;
