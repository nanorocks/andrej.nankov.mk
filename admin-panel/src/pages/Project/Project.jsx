import { Component, React } from "react";
import { MdModeEdit, MdDelete, MdNoteAdd } from "react-icons/md";
import { index, destroy } from "../../services/_index";
import { ApiMapper } from "../../config/_index";
import { Spinner } from "../../components/_index";
import { Link } from "react-router-dom";
import Alert from "../../components/Alert";

class Project extends Component {
  constructor(props) {
    super(props);
    this.state = {
      projects: [],
      paginationLinks: [],
      spinner: true,
    };
    this.pageSelected = 1;
    this.itemListSelected = 10;
    this.list = [10, 20, 50];
    this.queryTable = `${this.itemListSelected}&page=${this.pageSelected}`;
  }

  componentDidMount() {
    this.allProjects();
  }

  allProjects() {
    this.setState({ spinner: true });
    index(ApiMapper.project.index, this.queryTable).then((result) => {
      this.setState({
        projects: result[1].data.data,
        paginationLinks: result[1].data.links,
        spinner: false,
      });
    });
  }

  handleSelectedList(selected) {
    this.itemListSelected = selected;
    this.queryTable = `${this.itemListSelected}&page=1`;
    this.allProjects();
  }

  loadNewPage = (linkUrl) => {
    const url = new URL(linkUrl);
    const page = url.searchParams.get("page");
    this.pageSelected = page;
    this.queryTable = `${this.itemListSelected}&page=${this.pageSelected}`;
    this.allProjects();
  };

  deleteProject = (id) => {
    // eslint-disable-next-line no-restricted-globals
    if (!confirm("Are you sure you want to delete this item ?")) {
      return;
    }

    this.setState({ spinner: true });

    destroy(ApiMapper.project.destroy.replace(":id", id))
      .then((result) => {
        this.setState({
          spinner: false,
          projects: this.state.projects.filter((row) => row.id !== id),
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
              <th scope="col">Status</th>
              <th scope="col">Date</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            {this.state.projects.map((project, index) => {
              return (
                <tr key={index}>
                  <th scope="row">{index + 1}</th>
                  <td className="small">
                    {project.link ? (
                      <a
                        href={project.link ? project.link : "#"}
                        target="_blank"
                        rel="noopener noreferrer"
                        className="text-danger font-weight-bolder"
                      >
                        {project.title}
                      </a>
                    ) : (
                      <span className="font-weight-bolder">
                        {project.title}
                      </span>
                    )}
                  </td>
                  <td>{project.status}</td>
                  <td>{project.date}</td>
                  <td>
                    <div className="d-flex">
                      <Link to={`projects/${project.id}`}>
                        <button className="btn btn-link btn-sm text-muted font-weight-bolder">
                          <MdModeEdit fontSize="20" /> Edit
                        </button>
                      </Link>
                      <button
                        className="btn btn-link btn-sm text-danger font-weight-bolder"
                        onClick={() => this.deleteProject(project.id)}
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
            <div className="col-md-12">
              <div className="rounded-lg shadow m-4 p-4">
                <div className="d-flex justify-content-between">
                  <div>
                    <p className="font-weight-bold h5">Projects pages</p>
                    <small className="font-weight-light text-muted font-italic">
                      Configure your page in your client site
                    </small>
                  </div>
                  <div>
                    <Link to={`projects/new`}>
                      <button className="btn btn-outline-danger rounded-pill font-weight-bold">
                        <MdNoteAdd />
                        New Project
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
          </div>
        </div>
      </div>
    );
  }
}

export default Project;
