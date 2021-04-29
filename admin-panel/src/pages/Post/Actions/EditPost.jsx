import { Component, React } from "react";
import { show, update } from "../../../services/_index";
import { ApiMapper, Sanitize } from "../../../config/_index";
import { Link } from "react-router-dom";
import ReactQuill from "react-quill";
import Alert from "../../../components/Alert";
import ErrorsHandler from "../../../components/ErrorsHandler";
import Spinner from "../../../components/Spinner";

class EditPost extends Component {
  constructor(props) {
    super(props);
    this.state = {
      id: this.props.match.params.id,
      title: "",
      subTitle: "",
      text: "",
      date: "",
      status: 0,
      references: "",
      image: "",
      metaBudges: "",
      category: "",
      errors: [],
      spinner: false,
    };
  }

  componentDidMount() {
    this.showPost();
  }

  showPost() {
    this.setState({ spinner: true });
    show(ApiMapper.post.show.replace(":id", this.state.id)).then((result) => {
      const {
        title,
        subTitle,
        text,
        date,
        status,
        references,
        image,
        metaBudges,
        category,
      } = result[1].data;

      this.setState({
        spinner: false,
        title,
        subTitle,
        text,
        date,
        status,
        references: Sanitize.nullToEmpty(references),
        image: Sanitize.nullToEmpty(image),
        metaBudges,
        category,
      });
    });
  }

  updatePost() {
    this.setState({ errors: [] });
    const {
      title,
      subTitle,
      text,
      date,
      status,
      references,
      image,
      metaBudges,
      category,
    } = this.state;
    update(ApiMapper.post.update.replace(":id", this.state.id), {
      title,
      subTitle,
      text,
      date,
      status,
      references,
      image,
      metaBudges,
      category,
    }).then((result) => {
      if (result[0] === 422) {
        this.setState({ errors: result[1] });
        return;
      }
      Alert("success", result[1].message);
      this.props.history.push("/posts");
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
                    <p className="font-weight-bold h5">Edit Post</p>
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
                              placeholder="Enter post title"
                              onChange={(e) =>
                                this.setState({ title: e.target.value })
                              }
                              value={this.state.title}
                              required
                            />
                          </div>
                          <div className="col-md-6">
                            <label className="small font-weight-bold">
                              Sub Title
                            </label>
                            <input
                              type="text"
                              className="form-control"
                              id="sub-title"
                              placeholder="Enter post sub-title"
                              onChange={(e) =>
                                this.setState({ subTitle: e.target.value })
                              }
                              value={this.state.subTitle}
                              required
                            />
                          </div>
                        </div>
                        <div className="form-group">
                          <label className="small font-weight-bold">Text</label>
                          <div className="border rounded-sm p-2">
                            <ReactQuill
                              theme="snow"
                              onChange={(html) => {
                                this.setState({ text: html });
                              }}
                              placeholder="Enter post text"
                              value={this.state.text}
                            />
                          </div>
                        </div>
                        <div className="form-row pb-3">
                          <div className="col-md-6">
                            <label className="small font-weight-bold">
                              Date
                            </label>
                            <input
                              type="date"
                              className="form-control"
                              id="date"
                              placeholder="Enter post published date"
                              onChange={(e) =>
                                this.setState({ date: e.target.value })
                              }
                              value={this.state.date}
                              required
                            />
                          </div>
                          <div className="col-md-6">
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
                              placeholder="Enter post image url"
                              onChange={(e) =>
                                this.setState({ image: e.target.value })
                              }
                              value={this.state.image}
                              required
                            />
                          </div>
                        </div>
                        <div className="form-row pb-3">
                          <div className="col-md-6">
                            <label className="small font-weight-bold">
                              References{" "}
                              <span className="small text-muted">
                                (use delimiter `;` for multiple) (optional)
                              </span>
                            </label>
                            <textarea
                              type="date"
                              className="form-control"
                              id="references"
                              placeholder="Enter post references"
                              rows="4"
                              onChange={(e) =>
                                this.setState({ references: e.target.value })
                              }
                              value={this.state.references}
                              required
                            ></textarea>
                          </div>
                          <div className="col-md-6">
                            <label className="small font-weight-bold">
                              Meta Budges{" "}
                              <span className="small text-muted">
                                (use delimiter `;` for multiple)
                              </span>
                            </label>
                            <textarea
                              type="text"
                              className="form-control"
                              id="meta-budges"
                              placeholder="Enter post meta-budges"
                              rows="4"
                              onChange={(e) =>
                                this.setState({ metaBudges: e.target.value })
                              }
                              value={this.state.metaBudges}
                              required
                            ></textarea>
                          </div>
                        </div>
                        <div className="form-row pb-3">
                          <div className="col-md-6">
                            <label className="small font-weight-bold">
                              Category Name
                            </label>
                            <input
                              type="text"
                              className="form-control"
                              id="references"
                              placeholder="Enter post category name"
                              rows="4"
                              onChange={(e) =>
                                this.setState({ category: e.target.value })
                              }
                              value={this.state.category}
                              required
                            />
                          </div>
                          <div className="col-md-6 text-right pt-5">
                            <div className="form-check">
                              <input
                                type="checkbox"
                                className="form-check-input"
                                id="status"
                                onClick={(e) =>
                                  this.setState({
                                    status: e.target.checked ? 1 : 0,
                                  })
                                }
                                defaultChecked={
                                  this.state.status ? "checked" : ""
                                }
                                required
                              />
                              <label
                                htmlFor="status"
                                className="font-weight-bold form-check-label"
                              >
                                Published
                              </label>
                            </div>
                          </div>
                        </div>
                        <ErrorsHandler errors={this.state.errors} />
                        <div className="d-flex justify-content-between">
                          <Link to="/posts">
                            <button className="p-3 btn btn-dark btn-lg rounded-pill font-weight-bold">
                              Back
                            </button>
                          </Link>
                          <button
                            className="p-3 btn btn-danger btn-lg rounded-pill font-weight-bold"
                            onClick={() => this.updatePost()}
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

export default EditPost;
