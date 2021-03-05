import { Component, React } from "react";

class Config extends Component {
  render() {
    return (
      <div className="row">
        <div className="col-md-12">
          <div className="rounded-lg shadow m-4 p-4">
            <p className="font-weight-bold h5">Config pages</p>
            <small className="font-weight-light text-muted font-italic">
              Configure your page in your client site
            </small>
            <hr />
            <form>
              <div class="form-row">
                <div class="col-md-6">
                  <div className="form-group">
                    <label className="small font-weight-bold">Title</label>
                    <input
                      class="form-control"
                      type="text"
                      placeholder="Default input"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div className="form-group">
                    <label className="small font-weight-bold">
                      Description
                    </label>
                    <input
                      class="form-control"
                      type="text"
                      placeholder="Default input"
                    />
                  </div>
                </div>
              </div>
              <hr />

              <div class="form-row">
                <div class="col-md-6">
                  <div className="form-group">
                    <label className="small font-weight-bold">Title</label>
                    <input
                      class="form-control"
                      type="text"
                      placeholder="Default input"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div className="form-group">
                    <label className="small font-weight-bold">
                      Description
                    </label>
                    <input
                      class="form-control"
                      type="text"
                      placeholder="Default input"
                    />
                  </div>
                </div>
              </div>
              <hr />
              <div className="text-right">
                <button className="btn btn-danger rounded-pill pl-4 pr-4 font-weight-bolder text-capitalize">
                  Save
                  <div class="spinner-border spinner-border-sm ml-2" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    );
  }
}

export default Config;
