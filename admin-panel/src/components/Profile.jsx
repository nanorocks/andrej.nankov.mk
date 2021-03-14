import { Component, React } from "react";
import { show, store } from "../services/Crud";
import { ApiMapper, Sanitize } from "../config/_index";
import Spinner from "./Spinner";
import ReactQuill from "react-quill";
import "react-quill/dist/quill.snow.css";
import Alert from "../components/Alert";
import { KeyValue } from "./_index";

class Profile extends Component {
  constructor(props) {
    super(props);
    this.state = {
      id: "",
      email: "",
      name: "",
      intro: "",
      summary: "",
      currentWork: "",
      topProgrammingLanguages: "",
      goals: [],
      quotes: [],
      socMedia: "",
      highlights: [],
      address: "",
      phone: "",
      updatedAt: "",

      spinner: false,
    };
  }

  componentDidMount() {
    this.getProfile();
  }

  getProfile() {
    this.setState({ spinner: true });
    show(ApiMapper.profile.show, "").then((result) => {
      const {
        id,
        email,
        name,
        intro,
        summary,
        currentWork,
        topProgrammingLanguages,
        goals,
        quotes,
        socMedia,
        highlights,
        address,
        phone,
        updated_at: updatedAt,
      } = result[1].data;

      this.setState({
        spinner: false,
        id: id,
        email: email,
        name: name,
        intro: intro,
        summary: summary,
        currentWork: currentWork,
        topProgrammingLanguages: Sanitize.emptySpace(topProgrammingLanguages),
        goals: Sanitize.emptySpace(goals),
        quotes: Sanitize.parseJson(quotes),
        socMedia: Sanitize.parseJson(socMedia),
        highlights: highlights,
        address: address,
        phone: phone,
        updatedAt: Sanitize.momentFromNow(updatedAt),
      });
    });
  }

  saveProfile() {
    this.setState({ spinner: true });
    const {
      email,
      name,
      intro,
      summary,
      currentWork,
      topProgrammingLanguages,
      goals,
      quotes,
      socMedia,
      highlights,
      address,
      phone,
    } = this.state;

    store(
      ApiMapper.profile.store,
      {
        email,
        name,
        intro,
        summary,
        currentWork,
        topProgrammingLanguages,
        goals,
        quotes,
        socMedia,
        highlights,
        address,
        phone,
      },
      ""
    ).then((result) => {
      this.setState({ spinner: false });
      Alert("success", result[1].message);
    });
  }

  handleSocMedia = (SocMedia) => {
    this.setState({ socMedia: SocMedia });
  };

  handleQuotes = (Quotes) => {
    this.setState({ quotes: Quotes });
  };

  render() {
    return (
      <div className="row">
        <div className="col-md-12">
          <div className="rounded-lg shadow m-4 p-4">
            <p className="font-weight-bold h5">Profile info </p>
            <strong className="text-muted text-capitalize small font-weight-bold">
              Last update {this.state.updatedAt}
            </strong>
            <br />
            <small className="font-weight-light text-muted font-italic">
              Where you manage all core profile info for personal website.{" "}
            </small>
            <hr />
            {this.state.spinner ? (
              <Spinner />
            ) : (
              <form>
                <div className="form-row">
                  <div className="col-md-6">
                    <div className="form-group">
                      <label className="small font-weight-bold">Email</label>
                      <input
                        className="form-control"
                        type="text"
                        placeholder="Enter email address"
                        defaultValue={this.state.email}
                        onChange={(e) =>
                          this.setState({ email: e.target.value })
                        }
                        required
                      />
                    </div>
                  </div>
                  <div className="col-md-6">
                    <div className="form-group">
                      <label className="small font-weight-bold">Name</label>
                      <input
                        className="form-control"
                        type="text"
                        placeholder="Enter fullname"
                        defaultValue={this.state.name}
                        onChange={(e) =>
                          this.setState({ name: e.target.value })
                        }
                        required
                      />
                    </div>
                  </div>

                  <div className="col-md-6">
                    <div className="form-group">
                      <label className="small font-weight-bold">Address</label>
                      <input
                        className="form-control"
                        type="text"
                        placeholder="Enter home address"
                        defaultValue={this.state.address}
                        onChange={(e) =>
                          this.setState({ address: e.target.value })
                        }
                        required
                      />
                    </div>
                  </div>
                  <div className="col-md-6">
                    <div className="form-group">
                      <label className="small font-weight-bold">Phone</label>
                      <input
                        className="form-control"
                        type="text"
                        placeholder="Enter phone number"
                        defaultValue={this.state.phone}
                        onChange={(e) =>
                          this.setState({ phone: e.target.value })
                        }
                        required
                      />
                    </div>
                  </div>
                  <div className="col-md-12">
                    <div className="form-group">
                      <label className="small font-weight-bold">
                        Current Work
                      </label>
                      <ReactQuill
                        theme="snow"
                        value={String(this.state.currentWork)}
                        onChange={(html) => {
                          this.setState({ currentWork: html });
                        }}
                        placeholder="Enter current work"
                        className="border rounded-sm p-2"
                      />
                    </div>
                  </div>
                  <div className="col-md-12">
                    <label className="small font-weight-bold">Intro</label>
                    <div className="border rounded-sm p-2">
                      <ReactQuill
                        theme="snow"
                        value={String(this.state.intro)}
                        onChange={(html) => {
                          this.setState({ intro: html });
                        }}
                      />
                    </div>
                  </div>
                  <div className="col-md-12 pt-3">
                    <label className="small font-weight-bold">Summary</label>
                    <div className="border rounded-sm p-2">
                      <ReactQuill
                        theme="snow"
                        value={String(this.state.summary)}
                        onChange={(html) => {
                          this.setState({ summary: html });
                        }}
                      />
                    </div>
                  </div>
                  <div className="col-md-12 pt-3">
                    <label className="small font-weight-bold">Highlights</label>
                    <div className="border rounded-sm p-2">
                      <ReactQuill
                        theme="snow"
                        value={String(this.state.highlights)}
                        onChange={(html) => {
                          this.setState({ highlights: html });
                        }}
                      />
                    </div>
                  </div>
                  <div className="col-md-12 pt-3">
                    <div className="form-group">
                      <label className="small font-weight-bold">
                        Top programming languages
                      </label>
                      <textarea
                        className="form-control"
                        rows="6"
                        defaultValue={this.state.topProgrammingLanguages}
                        onChange={(e) =>
                          this.setState({
                            topProgrammingLanguages: e.target.value,
                          })
                        }
                      ></textarea>
                      <small className="text-muted font-italic">
                        <span className="text-danger">*</span> for icons we use{" "}
                        <a
                          href="https://fontawesome.com/"
                          target="_blank"
                          className="text-danger"
                          rel="noreferrer"
                        >
                          https://fontawesome.com/
                        </a>
                      </small>
                    </div>
                  </div>
                  <div className="col-md-12">
                    <div className="form-group">
                      <label className="small font-weight-bold">Goals </label>
                      <textarea
                        className="form-control"
                        rows="3"
                        defaultValue={this.state.goals}
                        onChange={(e) =>
                          this.setState({
                            goals: e.target.value,
                          })
                        }
                      ></textarea>
                      <small className="text-muted font-italic">
                        <span className="text-danger">*</span> separate with ;
                      </small>
                    </div>
                  </div>
                  <div className="col-md-12">
                    <div className="form-group">
                      <label className="small font-weight-bold">
                        Social media{" "}
                      </label>
                      <KeyValue
                        inputs={this.state.socMedia}
                        onChangeState={this.handleSocMedia}
                      />
                    </div>
                  </div>
                  <div className="col-md-12">
                    <div className="form-group">
                      <label className="small font-weight-bold">Quotes</label>
                      <KeyValue
                        inputs={this.state.quotes}
                        onChangeState={this.handleQuotes}
                      />
                    </div>
                  </div>
                </div>
                <div className="text-right mt-4">
                  <button
                    className="btn btn-danger btn-lg rounded-pill pl-4 pr-4 font-weight-bolder text-capitalize"
                    onClick={() => this.saveProfile()}
                    type="button"
                  >
                    Save Profile
                    {this.state.spinner && (
                      <div
                        className="spinner-border spinner-border-sm ml-2"
                        role="status"
                      >
                        <span className="sr-only">Loading...</span>
                      </div>
                    )}
                  </button>
                </div>
              </form>
            )}
          </div>
        </div>
      </div>
    );
  }
}

export default Profile;
