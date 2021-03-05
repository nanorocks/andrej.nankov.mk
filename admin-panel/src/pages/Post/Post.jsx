import { Component, React } from "react";
import { MdModeEdit, MdDelete } from "react-icons/md";

class Post extends Component {
  render() {
    return (
      <div>
        <div className="container">
          <div className="row">
            <div className="col-md-12">
              <div className="rounded-lg shadow m-4 p-4">
                <p className="font-weight-bold h5">Posts pages</p>
                <small className="font-weight-light text-muted font-italic">
                  Postsure your page in your client site
                </small>

                <div className="table-responsive pt-4">
                  <table class="table table-hover table-striped">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>
                          <div className="d-flex">
                            <button className="btn btn-link btn-sm text-muted font-weight-bolder">
                              <MdModeEdit fontSize="20" /> Edit
                            </button>
                            <button className="btn btn-link btn-sm text-danger font-weight-bolder">
                              <MdDelete fontSize="20" />
                              Delete
                            </button>
                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div className="d-flex jus">
                  <div className="mr-auto">
                    <nav>
                      <ul class="pagination pagination-sm">
                        <li class="page-item disabled">
                          <span class="page-link">Previous</span>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="#">
                            1
                          </a>
                        </li>
                        <li class="page-item active">
                          <a class="page-link" href="#">
                            2
                          </a>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="#">
                            3
                          </a>
                        </li>
                        <li class="page-item">
                          <a class="page-link" href="#">
                            Next
                          </a>
                        </li>
                      </ul>
                    </nav>
                  </div>
                  <div className="ml-auto">
                    <div class="form-group">
                      <select
                        id="inputState"
                        class="form-control form-control-sm"
                      >
                        <option value="10" selected>
                          10
                        </option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                      </select>
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

export default Post;
