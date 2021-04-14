import { React, Component } from "react";
import { read } from "./../services/apiReader";
import { mapper } from "./../config/mapper";
import { Spinner } from "./_index";
import { Link } from "react-router-dom";
import { withRouter } from "react-router-dom";
import AnchorLink from "react-anchor-link-smooth-scroll";

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
            {this.state.posts.length === 0 ? 'No published posts yet.' :
            this.state.posts.map((post, index) => {
              return !post.status ? '' : (
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
                {this.state.posts.length === 0 ? '' :
                this.state.links.map((link, index) => {
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
                      <AnchorLink
                        className="page-link"
                        href="#posts"
                        tabIndex={index}
                        onClick={() => this.loadNewPosts(link.url)}
                      >
                        {this.paginationLabelName(link.label)}
                      </AnchorLink>
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
