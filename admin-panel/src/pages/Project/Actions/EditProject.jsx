import { Component, React } from "react";
import { show, update } from "../../../services/_index";
import { ApiMapper, Sanitize } from "../../../config/_index";
import { Link } from "react-router-dom";
import Alert from "../../../components/Alert";
import ErrorsHandler from "../../../components/ErrorsHandler";
import Spinner from "../../../components/Spinner";

class EditProject extends Component {
  constructor(props) {
    super(props);
    this.state = {
      id: this.props.match.params.id,
      title: "",
      description: "",
      date: "",
      status: "",
      link: "",
      image: "",
      errors: [],
    };
  }

  componentDidMount() {
    this.showProject();
  }

  showProject() {
    this.setState({ spinner: true });
    show(ApiMapper.project.show.replace(":id", this.state.id)).then(
      (result) => {
        const {
          title,
          description,
          date,
          status,
          link,
          image,
        } = result[1].data;

        this.setState({
          spinner: false,
          title,
          description,
          date,
          status,
          link: Sanitize.nullToEmpty(link),
          image: Sanitize.nullToEmpty(image),
        });
      }
    );
  }

  updateProject() {
    this.setState({ errors: [] });
    const { title, description, date, status, link, image } = this.state;
    update(ApiMapper.project.update.replace(":id", this.state.id), {
      title,
      description,
      date,
      status,
      link,
      image,
    }).then((result) => {
      if (result[0] === 422) {
        this.setState({ errors: result[1] });
        return;
      }
      Alert("success", result[1].message);
      this.props.history.push("/projects");
    });
  }

  render() {
    return (
      <div>
        <div className="container">
          <div className="row">
            <div className="col-md-12">
              <div className="rounded-lg shadow border m-4 p-4">
                <div>
                  <div className="text-center">
                    <p className="font-weight-bold h5">Edit Project</p>
                    <small className="font-weight-light text-muted font-italic">
                      Edit config for client app.
                    </small>
                  </div>
                  {this.state.spinner ? (
                    <Spinner />
                  ) : (
                    <div className="row pt-4">
                      <div className="col-md-12">
                        <div className="form-row pb-3">
                          <div className="col-md-6">
                            <label className="small font-weight-bold">
                              Title
                            </label>
                            <input
                              type="text"
                              className="form-control"
                              id="title"
                              placeholder="Enter Title"
                              onChange={(e) =>
                                this.setState({ title: e.target.value })
                              }
                              value={this.state.title}
                            />
                          </div>
                          <div className="col-md-6">
                            <label className="small font-weight-bold">
                              Date
                            </label>
                            <input
                              type="date"
                              className="form-control"
                              id="date"
                              placeholder="Enter Date"
                              onChange={(e) =>
                                this.setState({ date: e.target.value })
                              }
                              value={this.state.date}
                            />
                          </div>
                        </div>
                        <div className="form-group">
                          <label className="small font-weight-bold">
                            Description
                          </label>
                          <textarea
                            type="date"
                            className="form-control"
                            id="description"
                            placeholder="Enter description"
                            rows="3"
                            onChange={(e) =>
                              this.setState({ description: e.target.value })
                            }
                            value={this.state.description}
                          ></textarea>
                        </div>
                        <div className="form-row pb-3">
                          <div className="col-md-4">
                            <label className="small font-weight-bold">
                              Link{" "}
                              <span className="small text-muted">
                                (optional)
                              </span>
                            </label>
                            <input
                              type="text"
                              className="form-control"
                              id="link"
                              placeholder="Enter Link"
                              onChange={(e) =>
                                this.setState({ link: e.target.value })
                              }
                              value={this.state.link}
                            />
                          </div>
                          <div className="col-md-4">
                            <label className="small font-weight-bold">
                              Image URL{" "}
                              <span className="small text-muted">
                                (optional)
                              </span>
                            </label>
                            <input
                              type="text"
                              className="form-control"
                              id="img-url"
                              placeholder="Enter Image url"
                              onChange={(e) =>
                                this.setState({ image: e.target.value })
                              }
                              value={this.state.image}
                            />
                          </div>
                          <div className="col-md-4">
                            <label className="small font-weight-bold">
                              Status{" "}
                              <span className="small text-danger font-italic">
                                (active | maintained | finished)
                              </span>
                            </label>
                            <input
                              type="text"
                              className="form-control"
                              id="status"
                              placeholder="Enter status like text"
                              onChange={(e) =>
                                this.setState({ status: e.target.value })
                              }
                              value={this.state.status}
                            />
                          </div>
                        </div>
                        <ErrorsHandler errors={this.state.errors} />
                        <div className="d-flex justify-content-between">
                          <Link to="/projects">
                            <button className="p-3 btn btn-dark btn-lg rounded-pill font-weight-bold">
                              Back
                            </button>
                          </Link>
                          <button
                            className="p-3 btn btn-danger btn-lg rounded-pill font-weight-bold"
                            onClick={() => this.updateProject()}
                          >
                            Submit
                          </button>
                        </div>
                      </div>
                    </div>
                  )}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    );
  }
}

export default EditProject;
