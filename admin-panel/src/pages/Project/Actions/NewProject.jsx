import { Component, React } from "react";
import { store } from "../../../services/_index";
import { ApiMapper } from "../../../config/_index";
import { Link } from "react-router-dom";

class NewProject extends Component {
  constructor(props) {
    super(props);
    this.state = {};
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
                  <p className="font-weight-bold h5">New Project</p>
                  <small className="font-weight-light text-muted font-italic">
                    Create new config for client app.
                  </small>
                </div>
                <div className="row pt-4">
                  <div className="col-md-12">
                    <div className="form-row pb-3">
                      <div class="col-md-6">
                        <label for="title" class="small font-weight-bold">
                          Title
                        </label>
                        <input
                          type="text"
                          class="form-control"
                          id="title"
                          placeholder="Enter Title"
                        />
                      </div>
                      <div class="col-md-6">
                        <label for="date" class="small font-weight-bold">
                          Date
                        </label>
                        <input
                          type="date"
                          class="form-control"
                          id="date"
                          placeholder="Enter Date"
                        />
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="references" class="small font-weight-bold">
                        Description
                      </label>
                      <textarea
                        type="date"
                        class="form-control"
                        id="references"
                        placeholder="Enter description"
                        rows="3"
                      ></textarea>
                    </div>
                    <div className="form-row pb-3">
                      <div class="col-md-4">
                        <label for="img-url" class="small font-weight-bold">
                          Link
                        </label>
                        <input
                          type="text"
                          class="form-control"
                          id="img-url"
                          placeholder="Enter Link"
                        />
                      </div>
                      <div class="col-md-4">
                        <label for="img-url" class="small font-weight-bold">
                          Image URL
                        </label>
                        <input
                          type="text"
                          class="form-control"
                          id="img-url"
                          placeholder="Enter Image url"
                        />
                      </div>
                      <div class="col-md-4">
                        <label for="img-url" class="small font-weight-bold">
                          Status{" "}
                          <span className="small text-danger font-italic">
                            (active | maintained | finished)
                          </span>
                        </label>
                        <input
                          type="text"
                          class="form-control"
                          id="img-url"
                          placeholder="Enter status like text"
                        />
                      </div>
                    </div>

                    <div className="d-flex justify-content-between">
                      <Link to="/projects">
                        <button class="btn btn-dark btn-lg rounded-pill font-weight-bold">
                          Back
                        </button>
                      </Link>
                      <button class="btn btn-danger btn-lg rounded-pill font-weight-bold">
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
