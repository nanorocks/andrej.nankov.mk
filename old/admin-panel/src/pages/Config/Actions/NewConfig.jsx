import { Component, React } from "react";
import { store } from "../../../services/_index";
import { ApiMapper } from "../../../config/_index";
import { Link } from "react-router-dom";
import newItem from "../../../img/newItem.png";
import ErrorsHandler from "../../../components/ErrorsHandler";
import Alert from "../../../components/Alert";
import { withRouter } from "react-router-dom";

class NewConfig extends Component {
  constructor(props) {
    super(props);
    this.state = {
      pageTitle: "",
      pageDescription: "",
      errors: [],
    };
  }

  storeConfig() {
    this.setState({errors: []});
    const { pageTitle, pageDescription } = this.state;
    store(ApiMapper.config.store, {
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
              <div className="rounded-lg shadow border m-4 p-4">
                <div className="text-center">
                  <p className="font-weight-bold h5">New Config</p>
                  <small className="font-weight-light text-muted font-italic">
                    Create new config for client app.
                  </small>
                </div>
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
                        onChange={(e) =>
                          this.setState({ pageDescription: e.target.value })
                        }
                        required
                      />
                    </div>
                    <ErrorsHandler errors={this.state.errors} />
                    <div className="d-flex justify-content-between">
                      <Link to="/configs">
                        <button className="p-3 btn btn-dark btn-lg rounded-pill font-weight-bold">
                          Back
                        </button>
                      </Link>
                      <button
                        className="p-3 btn btn-danger btn-lg rounded-pill font-weight-bold"
                        onClick={() => this.storeConfig()}
                      >
                        Submit
                      </button>
                    </div>
                  </div>
                  <div className="col-md-4 text-center">
                    <img src={newItem} alt="example" className="w-75" />
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

export default withRouter(NewConfig);
