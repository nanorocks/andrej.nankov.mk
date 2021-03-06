import { Component, React } from "react";
import { MdModeEdit, MdDelete } from "react-icons/md";
import { index } from "../../services/_index";
import { ApiMapper } from "../../config/_index";

class Config extends Component {

  constructor(props){
    super(props);
    this.state = {

    }
  }

  componentDidMount(){
    this.allConfigs();
  }

  allConfigs(){
    index(ApiMapper.config.index).then(result => {
      console.log(result);
    })
  }

  render() {
    return (
      <div>
        <div className="container">
          <div className="row">
            <div className="col-md-12">
              <div className="rounded-lg shadow m-4 p-4">
                <p className="font-weight-bold h5">Config pages</p>
                <small className="font-weight-light text-muted font-italic">
                  Configure your page in your client site
                </small>
                <div className="table-responsive pt-4">
                  <table className="table table-hover table-striped">
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
                      <ul className="pagination pagination-sm">
                        <li className="page-item disabled">
                          <span className="page-link">Previous</span>
                        </li>
                        <li className="page-item">
                          <a className="page-link" href="#">
                            1
                          </a>
                        </li>
                        <li className="page-item active">
                          <a className="page-link" href="#">
                            2
                          </a>
                        </li>
                        <li className="page-item">
                          <a className="page-link" href="#">
                            3
                          </a>
                        </li>
                        <li className="page-item">
                          <a className="page-link" href="#">
                            Next
                          </a>
                        </li>
                      </ul>
                    </nav>
                  </div>
                  <div className="ml-auto">
                    <div className="form-group">
                      <select
                        id="inputState"
                        className="form-control form-control-sm"
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

export default Config;
