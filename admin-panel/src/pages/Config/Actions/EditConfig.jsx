import { Component, React } from "react";
import { show, update } from "../../../services/_index";
import { ApiMapper } from "../../../config/_index";
import { Link } from "react-router-dom";
import editItem from "../../../img/editItem.png";
import Alert from "../../../components/Alert";
import ErrorsHandler from "../../../components/ErrorsHandler";
import Spinner from "../../../components/Spinner";

class EditConfig extends Component {
  constructor(props) {
    super(props);
    this.state = {
      id: this.props.match.params.id,
      pageTitle: "",
      pageDescription: "",
      errors: [],
      spinner: false,
    };
  }

  componentDidMount() {
    this.showConfig();
  }

  showConfig() {
    this.setState({ spinner: true });
    show(ApiMapper.config.show.replace(":id", this.state.id)).then((result) => {
      const { pageTitle, pageDescription } = result[1].data;
      this.setState({
        spinner: false,
        pageTitle,
        pageDescription,
      });
    });
  }

  updateConfig() {
    this.setState({ errors: [] });
    const { pageTitle, pageDescription } = this.state;
    update(ApiMapper.config.update.replace(":id", this.state.id), {
      pageTitle,
      pageDescription,
    }).then((result) => {
      if (result[0] === 422) {
        this.setState({ errors: result[1] });
        return;
      }
      Alert("success", result[1].message);
      this.props.history.push("/configs");
    });
  }

  render() {
    return (
      <div>
        <div className="container">
          <div className="row">
            <div className="col-md-12">
              <div className="rounded-lg shadow m-4 p-4">
                <div>
                  <div className="text-center">
                    <p className="font-weight-bold h5">Edit Config</p>
                    <small className="font-weight-light text-muted font-italic">
                      Edit config for client app.
                    </small>
                  </div>
                  {this.state.spinner ? (
                    <Spinner />
                  ) : (
                    <div className="row pt-4">
                      <div className="col-md-8">
                        <div className="mb-3">
                          <label className="form-label">
                            Title
                          </label>
                          <input
                            type="text"
                            className="form-control"
                            id="title"
                            placeholder="Enter config title"
                            value={this.state.pageTitle}
                            onChange={(e) =>
                              this.setState({ pageTitle: e.target.value })
                            }
                            required
                          />
                        </div>
                        <div className="mb-3">
                          <label className="form-label">
                            Description
                          </label>
                          <input
                            type="text"
                            className="form-control"
                            id="description"
                            placeholder="Enter config description"
                            value={this.state.pageDescription}
                            onChange={(e) =>
                              this.setState({ pageDescription: e.target.value })
                            }
                            required
                          />
                        </div>
                        <ErrorsHandler errors={this.state.errors} />
                        <div className="d-flex justify-content-between">
                          <Link to="/configs">
                            <button className="btn btn-dark btn-lg rounded-pill font-weight-bold">
                              Back
                            </button>
                          </Link>
                          <button
                            className="btn btn-danger btn-lg rounded-pill font-weight-bold"
                            onClick={() => this.updateConfig()}
                          >
                            Submit
                          </button>
                        </div>
                      </div>
                      <div className="col-md-4 text-center">
                        <img src={editItem} alt="edit img" className="w-75" />
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

export default EditConfig;
