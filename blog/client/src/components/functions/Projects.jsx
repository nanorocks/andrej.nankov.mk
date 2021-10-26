import { React } from "react";
import { Spinner } from "../_index";
import { withRouter } from "react-router-dom";
import useListHook from "../../hooks/useListHook";
import { mapper } from "../../config/mapper";

export default withRouter(function Projects(props) {
  const [
    { links, items: projects, spinner },
    paginationLabelName,
    loadNewItems,
  ] = useListHook(mapper.displayProjects);

  return (
    <section className="resume-section" id="projects">
      <div className="resume-section-content">
        <h2 className="mb-5">Projects</h2>
        {projects.length === 0
          ? "No published projects yet."
          : projects.map((project, index) => {
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
                      More...
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
              {links.map((link, index) => {
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
                      href="#projects"
                      tabIndex={index}
                      onClick={() => loadNewItems(link.url)}
                    >
                      {paginationLabelName(link.label)}
                    </button>
                  </li>
                );
              })}
            </ul>
          </div>
          {spinner && <Spinner />}
        </div>
      </div>
    </section>
  );
});
