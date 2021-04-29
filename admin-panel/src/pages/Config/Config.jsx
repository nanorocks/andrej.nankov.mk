import { Component, React } from "react";
import { MdModeEdit, MdDelete, MdNoteAdd } from "react-icons/md";
import { index, destroy } from "../../services/_index";
import { ApiMapper } from "../../config/_index";
import { Spinner } from "../../components/_index";
import { Link } from "react-router-dom";
import Alert from "../../components/Alert";
import config from "../../img/config.png";

class Config extends Component {
  constructor(props) {
    super(props);
    this.state = {
      configs: [],
      paginationLinks: [],
      spinner: true,
      toggleImage: false
    };
    this.pageSelected = 1;
    this.itemListSelected = 10;
    this.list = [10, 20, 50];
    this.queryTable = `${this.itemListSelected}&page=${this.pageSelected}`;
  }

  componentDidMount() {
    this.allConfigs();
  }

  allConfigs() {
    this.setState({ spinner: true });
    index(ApiMapper.config.index, this.queryTable).then((result) => {
      this.setState({
        configs: result[1].data.data,
        paginationLinks: result[1].data.links,
        spinner: false,
      });
    });
  }

  handleSelectedList(selected) {
    this.itemListSelected = selected;
    this.queryTable = `${this.itemListSelected}&page=1`;
    this.allConfigs();
  }

  loadNewPage = (linkUrl) => {
    const url = new URL(linkUrl);
    const page = url.searchParams.get("page");
    this.pageSelected = page;
    this.queryTable = `${this.itemListSelected}&page=${this.pageSelected}`;
    this.allConfigs();
  };

  deleteConfig = (id) => {
    // eslint-disable-next-line no-restricted-globals
    if (!confirm("Are you sure you want to delete this item ?")) {
      return;
    }

    this.setState({ spinner: true });

    destroy(ApiMapper.config.destroy.replace(":id", id))
      .then((result) => {
        this.setState({
          spinner: false,
          configs: this.state.configs.filter((row) => row.id !== id),
        });

        Alert("success", result[1].message);
      })
      .catch((err) => {
        if (err.response) {
          Alert("error", err.response.data.error);
        }
      });
  };

  table() {
    return (
      <div className="table-responsive pt-4">
        <table className="table table-hover table-striped table-sm">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Title</th>
              <th scope="col">Description</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            {this.state.configs.map((config, index) => {
              return (
                <tr key={index}>
                  <th scope="row">{index + 1}</th>
                  <td>{config.pageTitle}</td>
                  <td>{config.pageDescription}</td>
                  <td>
                    <div className="d-flex">
                      <Link to={`configs/${config.id}`}>
                        <button className="btn btn-link btn-sm text-muted font-weight-bolder">
                          <MdModeEdit fontSize="20" /> Edit
                        </button>
                      </Link>
                      <button
                        className="btn btn-link btn-sm text-danger font-weight-bolder"
                        onClick={() => this.deleteConfig(config.id)}
                      >
                        <MdDelete fontSize="20" />
                        Delete
                      </button>
                    </div>
                  </td>
                </tr>
              );
            })}
          </tbody>
        </table>
      </div>
    );
  }
  render() {
    return (
      <div>
        <div className="container">
          <div className="row">
            <div className="col-sm-12 col-md-12 col-lg-12 col-12">
              <div className="rounded-lg shadow border m-4 p-4">
                <div className="d-flex justify-content-between">
                  <div>
                    <p className="font-weight-bold h5">Config pages</p>
                    <small className="font-weight-light text-muted font-italic">
                      Configure your page in your client site
                    </small>
                  </div>
                  <div>
                    <Link to={`configs/new`}>
                      <button className="btn btn-outline-danger rounded-pill font-weight-bold">
                        <MdNoteAdd />
                        New Config
                      </button>
                    </Link>
                  </div>
                </div>
                {this.state.spinner ? <Spinner /> : this.table()}
                <div className="d-flex">
                  <div className="mr-auto">
                    <nav>
                      <ul className="pagination pagination-sm">
                        {this.state.paginationLinks.map((link, index) => {
                          return (
                            <li
                              key={index}
                              className={
                                link.active
                                  ? "page-item active"
                                  : link.url == null
                                  ? "page-item disabled"
                                  : "page-item"
                              }
                            >
                              <button
                                className={`page-link`}
                                onClick={() => this.loadNewPage(link.url)}
                              >
                                {link.label
                                  .toString()
                                  .replace("pagination.next", "Next")
                                  .replace("pagination.previous", "Previous")}
                              </button>
                            </li>
                          );
                        })}
                      </ul>
                    </nav>
                  </div>
                  <div className="ml-auto">
                    <div className="form-group">
                      <select
                        id="inputState"
                        className="form-control form-control-sm"
                        onChange={(e) =>
                          this.handleSelectedList(e.target.value)
                        }
                      >
                        {this.list.map((listItem, index) => (
                          <option value={listItem} key={index}>
                            {listItem}
                          </option>
                        ))}
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div className="col-md-12">
              <div className="text-left pr-4">
                <span className="pl-4 text-muted font-italic small d-block">
                  Where you can find old and new configs in website ? Toggle{" "}
                  <span
                    className="text-danger"
                    onClick={() => {
                      this.setState({ toggleImage: !this.state.toggleImage });
                      setTimeout(() => {
                        Alert("danger", "Nothing fancy, only screenshot and arrow ;)");
                      }, 500)
                    }}
                  >
                    here
                  </span>{" "}
                  ...
                </span>
                <img
                  src={config}
                  alt="config_image"
                  className={
                    this.state.toggleImage
                      ? "img-thumbnail ml-4 img-fluid"
                      : "d-none"
                  }
                />
              </div>
            </div>
          </div>
        </div>
      </div>
    );
  }
}

export default Config;
