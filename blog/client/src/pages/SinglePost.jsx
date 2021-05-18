import { React, Component } from "react";
import { Navbar } from "./../components/_index";
import { withRouter } from "react-router-dom";
import { read } from "./../services/apiReader";
import { mapper } from "./../config/mapper";

class SinglePost extends Component {
  constructor(props) {
    super(props);
    this.state = {
      title: "",
      text: "",
      subTitle: "",
      status: "",
      references: "",
      metaBudges: "",
      image: null,
      date: "",
      category: null,
      name: "",
      email: "",
      photo: "",
      spinner: false,
    };
  }

  componentDidMount() {
    this.getPost();
  }

  getPost() {
    let uuid = this.props.match.params.uuid;
    this.setState({ spinner: true });
    read(mapper.showPostByUuid.replace(":id", uuid))
      .then((result) => {
        const {
          title,
          subTitle,
          name,
          date,
          text,
          category,
          references,
          metaBudges,
          image,
          email,
          photo,
        } = result.data;
        this.setState({
          title,
          subTitle,
          name,
          date,
          text,
          category,
          references,
          metaBudges,
          image: image.trim().length > 0 ? image : "",
          email,
          photo,
        });

        setTimeout(() => {
          this.setState({ spinner: false });
        }, 100);
      })
      .catch((error) => {
        console.log(error);
        this.props.history.push("/500");
      });
  }

  render() {
    return (
      <div>
        <Navbar
          email={this.state.email}
          name={this.state.name}
          photo={this.state.photo}
        />
        {!this.state.spinner && (
          <section className="resume-section" id="summary">
            <div className="resume-section-content">
              <div className="mb-1 font-italic small text-capitalize">
                {this.state.category !== ""
                  ? "Category: " + this.state.category
                  : ""}
              </div>
              <h2 className="mb-1">{this.state.title}</h2>
              <div className="mb-1 font-italic small">
                by {this.state.name} on {this.state.date}
              </div>
              <div className="mb-4 font-italic small">
                {this.state.metaBudges.split(";").map((meta, index) => {
                  return (
                    <span
                      key={index}
                      className="badge badge-pill badge-secondary mr-1 p-2"
                    >
                      {meta}
                    </span>
                  );
                })}
              </div>
              <div className="subheading mb-3">
                {this.state.image !== "" && (
                  <img
                    src={this.state.image}
                    alt={this.state.title}
                    className="d-none d-sm-none d-md-block d-lg-block col-4 w-100 p-0"
                  />
                )}
              </div>
              <div className="subheading mb-3">{this.state.subTitle}</div>
              <div
                className="mb-3"
                dangerouslySetInnerHTML={{ __html: this.state.text }}
              ></div>
              <p className="mb-3"></p>
              <div className="resume-section-content small">
                {this.state.references.length > 0 && (
                  <div className="mb-2">REFERENCES</div>
                )}
                <ul className="list-unstyled">
                  {this.state.references !== ""
                    ? this.state.references
                        .split(";")
                        .map((reference, index) => {
                          return (
                            <li key={index} className="text-">
                              <a href={reference}>{reference}</a>
                            </li>
                          );
                        })
                    : ""}
                </ul>
              </div>
            </div>
          </section>
        )}
      </div>
    );
  }
}

export default withRouter(SinglePost);
