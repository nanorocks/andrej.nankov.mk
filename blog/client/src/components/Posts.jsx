import { React, Component } from "react";
import { read } from "./../services/apiReader";
import { mapper } from "./../config/mapper";
import { Spinner } from "./_index";
import { Link } from "react-router-dom";
import { withRouter } from "react-router-dom";

class Posts extends Component {
  constructor(props) {
    super(props);
    this.state = {
      posts: [],
      links: [],
      spinner: false,
    };
  }

  query = "&";

  componentDidMount() {
    this.loadPosts();
  }

  loadPosts() {
    read(mapper.displayPosts, this.query)
      .then((result) => {
        this.setState({ posts: result.data.data });
        this.setState({ links: result.data.links });
      })
      .catch((error) => {
        console.log(error);
        this.props.history.push("/500");
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

  loadNewPosts = (url) => {
    this.setState({ spinner: true });

    let urlParams = new URL(url);
    let page = urlParams.searchParams.get("page");

    this.query = "&page=" + page;

    this.loadPosts();

    setTimeout(() => {
      this.setState({ spinner: false });
    }, 1000);
  };

  render() {
    return (
      <section className="resume-section" id="latest-posts">
        <div className="resume-section-content">
          <h2 className="mb-5">Latest Posts</h2>
          <ul className="fa-ul mb-0">
            {this.state.posts.map((post, index) => {
              return (
                <li key={index} className="mb-3">
                  <h5 className="fa-li">
                    <i className="fas fa-file text-warning"></i>
                  </h5>
                  <Link to={`/post/` + post.unique_id}>
                    <h5>{post.title}</h5>
                  </Link>
                </li>
              );
            })}
          </ul>
          <div className="d-flex mt-5">
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
                        onClick={() => this.loadNewPosts(link.url)}
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

export default withRouter(Posts);
