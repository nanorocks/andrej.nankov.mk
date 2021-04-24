import { Component, React } from "react";
import { store } from "../../../services/_index";
import { ApiMapper } from "../../../config/_index";
import { Link } from "react-router-dom";
import Alert from "../../../components/Alert";
import ErrorsHandler from "../../../components/ErrorsHandler";


class NewProject extends Component {
  constructor(props) {
    super(props);
    this.state = {
      title: "",
      description: "",
      date: "",
      status: "",
      link: "",
      image: "",
      errors: [],
    };
  }

  storeProject() {
    this.setState({ errors: [] });
    const { title, description, date, status, link, image } = this.state;

    store(ApiMapper.project.store, {
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
              <div className="rounded-lg shadow m-4 p-4">
                <div className="text-center">
                  <p className="font-weight-bold h5">New Project</p>
                  <small className="font-weight-light text-muted font-italic">
                    Create new config for client app.
                  </small>
                </div>
                <div className="row pt-4">
                  <div className="col-md-12">
                    <div className="form-row pb-3">
                      <div className="col-md-6">
                        <label className="small font-weight-bold">Title</label>
                        <input
                          type="text"
                          className="form-control"
                          id="title"
                          placeholder="Enter Title"
                          onChange={(e) =>
                            this.setState({ title: e.target.value })
                          }
                        />
                      </div>
                      <div className="col-md-6">
                        <label className="small font-weight-bold">Date</label>
                        <input
                          type="date"
                          className="form-control"
                          id="date"
                          placeholder="Enter Date"
                          onChange={(e) =>
                            this.setState({ date: e.target.value })
                          }
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
                        id="references"
                        placeholder="Enter description"
                        rows="3"
                        onChange={(e) =>
                          this.setState({ description: e.target.value })
                        }
                      ></textarea>
                    </div>
                    <div className="form-row pb-3">
                      <div className="col-md-4">
                        <label className="small font-weight-bold">Link</label>
                        <input
                          type="text"
                          className="form-control"
                          id="img-url"
                          placeholder="Enter Link"
                          onChange={(e) =>
                            this.setState({ link: e.target.value })
                          }
                        />
                      </div>
                      <div className="col-md-4">
                        <label className="small font-weight-bold">
                          Image URL
                        </label>
                        <input
                          type="text"
                          className="form-control"
                          id="img-url"
                          placeholder="Enter Image url"
                          onChange={(e) =>
                            this.setState({ image: e.target.value })
                          }
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
                          id="img-url"
                          placeholder="Enter status like text"
                          onChange={(e) =>
                            this.setState({ status: e.target.value })
                          }
                        />
                      </div>
                    </div>
                    <ErrorsHandler errors={this.state.errors} />
                    <div className="d-flex justify-content-between">
                      <Link to="/projects">
                        <button className="btn btn-dark btn-lg rounded-pill font-weight-bold">
                          Back
                        </button>
                      </Link>
                      <button
                        className="btn btn-danger btn-lg rounded-pill font-weight-bold"
                        onClick={() => this.storeProject()}
                      >
                        Submit
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    );
  }
}

export default NewProject;
