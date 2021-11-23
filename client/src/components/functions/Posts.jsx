import { React } from "react";
import { Spinner } from "./../../components/_index";
import { Link } from "react-router-dom";
import { withRouter } from "react-router-dom";
import useListHook from "../../hooks/useListHook";
import { mapper } from "./../../config/mapper";

export default withRouter(function Posts(props) {
  const [{ links, items: posts, spinner }, paginationLabelName, loadNewItems] =
    useListHook(mapper.displayPosts);

  return (
    <section className="resume-section" id="latest-posts">
      <div className="resume-section-content">
        <h2 className="mb-5">Latest Posts</h2>
        <ul className="fa-ul mb-0">
          {posts.length === 0
            ? "No published posts yet."
            : posts.map((post, index) => {
                return !post.status ? (
                  ""
                ) : (
                  <li key={index} className="mb-3">
                    <h5 className="fa-li">
                      <i className="fas fa-file text-warning"></i>
                    </h5>
                    <Link to={`/post/` + post.unique_id} target="_blank">
                      <h5>{post.title}</h5>
                    </Link>
                  </li>
                );
              })}
        </ul>
        <div className="d-flex mt-5">
          <div className="pr-2">
            <ul className="pagination">
              {posts.length === 0
                ? ""
                : links.map((link, index) => {
                    return (
                      <li
                        key={index}
                        className={
                          link.url === null
                            ? `page-item disabled`
                            : link.active
                            ? `page-item active`
                            : `page-item`
                        }
                      >
                        <button
                          className="page-link"
                          href="#posts"
                          tabIndex={index}
                          onClick={(e) => {
                            loadNewItems(link.url);
                          }}
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
