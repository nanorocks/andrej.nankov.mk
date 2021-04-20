import { Component, React } from "react";
import { store } from "../../../services/_index";
import { ApiMapper } from "../../../config/_index";
import { Link } from "react-router-dom";
import newItem from "../../../img/newItem.png";
class NewConfig extends Component {
  constructor(props) {
    super(props);
    this.state = {
      configTitle: "",
      configDescription: "",
    };
  }

  storeConfig() {
    store(ApiMapper.config.index, this.queryTable).then((result) => {
      this.setState({
        paginationLinks: result[1].data.links,
      });
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
                  <p className="font-weight-bold h5">New Config</p>
                  <small className="font-weight-light text-muted font-italic">
                    Create new config for client app.
                  </small>
                </div>
                <div className="row pt-4">
                  <div className="col-md-8">
                    <div class="mb-3">
                      <label for="title" class="form-label">
                        Title
                      </label>
                      <input
                        type="text"
                        class="form-control"
                        id="title"
                        placeholder="Enter config title"
                      />
                    </div>
                    <div class="mb-3">
                      <label for="description" class="form-label">
                        Description
                      </label>
                      <input
                        type="text"
                        class="form-control"
                        id="description"
                        placeholder="Enter config description"
                      />
                    </div>
                    <div className="d-flex justify-content-between">
                      <Link to="/configs">
                        <button class="btn btn-dark btn-lg rounded-pill font-weight-bold">
                          Back
                        </button>
                      </Link>
                      <button class="btn btn-danger btn-lg rounded-pill font-weight-bold">
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

export default NewConfig;
