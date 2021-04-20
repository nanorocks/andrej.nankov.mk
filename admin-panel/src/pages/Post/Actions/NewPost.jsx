import { Component, React } from "react";
import { store } from "../../../services/_index";
import { ApiMapper } from "../../../config/_index";
import { Link } from "react-router-dom";
import ReactQuill from "react-quill";

class NewPost extends Component {
  constructor(props) {
    super(props);
    this.state = {
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
                  <p className="font-weight-bold h5">New Post</p>
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
                        <label for="sub-title" class="small font-weight-bold">
                          Sub Title
                        </label>
                        <input
                          type="text"
                          class="form-control"
                          id="sub-title"
                          placeholder="Enter Sub-Title"
                        />
                      </div>
                    </div>
                    <div className="form-group">
                      <label className="small font-weight-bold">Text</label>
                      <div className="border rounded-sm p-2">
                        <ReactQuill
                          theme="snow"
                          // value={String(this.state.highlights)}
                          // onChange={(html) => {
                          //   this.setState({ highlights: html });
                          // }}
                        />
                      </div>
                    </div>
                    <div className="form-row pb-3">
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
                      <div class="col-md-6">
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
                    </div>
                    <div className="form-row pb-3">
                      <div class="col-md-6">
                        <label for="references" class="small font-weight-bold">
                          References
                        </label>
                        <textarea
                          type="date"
                          class="form-control"
                          id="references"
                          placeholder="Enter references"
                          rows="4"
                        ></textarea>
                      </div>
                      <div class="col-md-6">
                        <label for="meta-budges" class="small font-weight-bold">
                          Meta Budges
                        </label>
                        <textarea
                          type="text"
                          class="form-control"
                          id="meta-budges"
                          placeholder="Enter meta budges"
                          rows="4"
                        ></textarea>
                      </div>
                    </div>
                    <div className="form-row pb-3">
                      <div class="col-md-6">
                        <label for="references" class="small font-weight-bold">
                          Category
                        </label>
                        <input
                          type="text"
                          class="form-control"
                          id="references"
                          placeholder="Enter category name"
                          rows="4"
                        />
                      </div>
                      <div class="col-md-6 text-right pt-5">
                        <div className="form-check">
                          <input
                            type="checkbox"
                            class="form-check-input"
                            id="metaBudges"
                            placeholder="Enter meta budges"
                            rows="4"
                          />
                          <label
                            for="metaBudges"
                            class="font-weight-bold form-check-label"
                          >
                            Published
                          </label>
                        </div>
                      </div>
                    </div>

                    <div className="d-flex justify-content-between">
                      <Link to="/posts">
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

export default NewPost;
