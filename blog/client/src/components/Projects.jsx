import { React, Component } from "react";
import { mapper } from "./../config/mapper";
import { read } from "./../services/apiReader";
import { Spinner } from "./_index";

class Projects extends Component {
  constructor(props) {
    super(props);
    this.state = {
      projects: [],
      links: [],
      query: "&",
      spinner: false,
    };
  }

  componentDidMount() {
    this.loadProjects();
  }

  loadProjects() {
    read(mapper.displayProjects, this.state.query)
      .then((result) => {
        this.setState({ projects: result.data.data });
        this.setState({ links: result.data.links });
      })
      .catch((error) => {
        console.log(error);
      });
  }

  paginationLabelName(label) {
    if (label === "pagination.previous") {
      return "Previous";
    } else if (label === "pagination.next") {
      return "Next";
    }

    return label;
  }

  loadNewProjects = (url) => {
    this.setState({ spinner: true });

    let urlParams = new URL(url);
    let page = urlParams.searchParams.get("page");

    this.state.query = "&page=" + page; 

    this.loadProjects();

    setTimeout(() => {
      this.setState({ spinner: false });
    }, 1000);
  };

  render() {
    return (
      <section className="resume-section" id="projects">
        <div className="resume-section-content">
          <h2 className="mb-5">Projects</h2>
          {this.state.projects.map((project, index) => {
            return (
              <div
                className="d-flex flex-column flex-md-row justify-content-between mb-5"
                key={index}
              >
                <div className="flex-grow-1">
                  <div className="row">
                    <div className="d-none d-sm-block d-md-block d-lg-block col-sm-2 col-md-1 col-lg-2">
                      {project.image != null ? (
                        <img
                          src={project.image}
                          alt={project.title}
                          className="img-fluid w-75 d-block mx-auto rounded shadow"
                        />
                      ) : (
                        <img
                          src={
                            `https://eu.ui-avatars.com/api/?size=128&background=random&name=` +
                            project.title
                          }
                          alt={project.title}
                          className="img-fluid w-75 d-block mx-auto rounded shadow"
                        />
                      )}
                    </div>
                    <div className="col-12 col-sm-10 col-md-11 col-lg-10">
                      <h3 className="mb-0">{project.title}</h3>
                      <div className="subheading mb-3">
                        STATUS: {project.status}
                      </div>
                    </div>
                  </div>
                  <div className="pt-2">{project.description}</div>
                  {project.link != null && (
                    <a href={project.link} target="_blank" rel="noreferrer">
                      More...{" "}
                    </a>
                  )}
                </div>
                <div className="flex-shrink-0">
                  <span className="text-primary small font-weight-light">
                    DATE: {project.date}
                  </span>
                </div>
              </div>
            );
          })}
          <div className="d-flex">
            <div className="pr-2">
              <ul className="pagination">
                {this.state.links.map((link, index) => {
                  return (
                    <li
                      key={index}
                      className={
                        link.url == null
                          ? `page-item disabled`
                          : link.active
                          ? `page-item active`
                          : `page-item`
                      }
                    >
                      <button
                        className="page-link"
                        href="#"
                        tabIndex={index}
                        onClick={() => this.loadNewProjects(link.url)}
                      >
                        {this.paginationLabelName(link.label)}
                      </button>
                    </li>
                  );
                })}
              </ul>
            </div>
            {this.state.spinner && <Spinner />}
          </div>
        </div>
      </section>
    );
  }
}

export default Projects;
