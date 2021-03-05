import { Component, React } from "react";
import { Editor, EditorState, RichUtils } from "draft-js";
import "draft-js/dist/Draft.css";

class Profile extends Component {
  constructor(props) {
    super(props);
    this.state = { editorState: EditorState.createEmpty() };
    this.onChange = (editorState) => this.setState({ editorState });
    this.handleKeyCommand = this.handleKeyCommand.bind(this);
  }

  handleKeyCommand(command, editorState) {
    const newState = RichUtils.handleKeyCommand(editorState, command);

    if (newState) {
      this.onChange(newState);
      return "handled";
    }

    return "not-handled";
  }

  render() {
    return (
      <div className="row">
        <div className="col-md-12">
          <div className="rounded-lg shadow m-4 p-4">
            <p className="font-weight-bold h5">Profile info</p>
            <small className="font-weight-light text-muted font-italic">
              Where you manage all core profile info for personal website.
            </small>
            <hr />
            <form>
              <div className="form-row">
                <div className="col-md-6">
                  <div className="form-group">
                    <label className="small font-weight-bold">Email</label>
                    <input
                      className="form-control"
                      type="text"
                      placeholder="Default input"
                    />
                  </div>
                </div>
                <div className="col-md-6">
                  <div className="form-group">
                    <label className="small font-weight-bold">Name</label>
                    <input
                      className="form-control"
                      type="text"
                      placeholder="Default input"
                    />
                  </div>
                </div>

                <div className="col-md-6">
                  <div className="form-group">
                    <label className="small font-weight-bold">Address</label>
                    <input
                      className="form-control"
                      type="text"
                      placeholder="Default input"
                    />
                  </div>
                </div>
                <div className="col-md-6">
                  <div className="form-group">
                    <label className="small font-weight-bold">Phone</label>
                    <input
                      className="form-control"
                      type="text"
                      placeholder="Default input"
                    />
                  </div>
                </div>
                <div className="col-md-12">
                  <div className="form-group">
                    <label className="small font-weight-bold">
                      Current Work
                    </label>
                    <input
                      className="form-control"
                      type="text"
                      placeholder="Default input"
                    />
                  </div>
                </div>
                <div className="col-md-12">
                  <div className="form-group">
                    <label className="small font-weight-bold">
                      Top programming languages
                    </label>
                    <textarea className="form-control" rows="3"></textarea>
                    <small className="text-muted font-italic">
                      <span className="text-danger">*</span> for icons we use{" "}
                      <a href="https://fontawesome.com/" target="_blank">
                        https://fontawesome.com/
                      </a>
                    </small>
                  </div>
                </div>
                <div className="col-md-12">
                  <div className="form-group">
                    <label className="small font-weight-bold">Goals </label>
                    <textarea className="form-control" rows="5"></textarea>
                    <small className="text-muted font-italic">
                      <span className="text-danger">*</span> separate with ;
                    </small>
                  </div>
                </div>
                <div className="col-md-12">
                  <label className="small font-weight-bold">Intro</label>
                  <div className="border rounded-sm p-2">
                    <Editor
                      className="shadow"
                      editorState={this.state.editorState}
                      onChange={this.onChange}
                      handleKeyCommand={this.handleKeyCommand}
                      placeholder="Your intro here ..."
                    />
                  </div>
                </div>
                <div className="col-md-12 pt-3">
                  <label className="small font-weight-bold">Summary</label>
                  <div className="border rounded-sm p-2">
                    <Editor
                      className="shadow"
                      editorState={this.state.editorState}
                      onChange={this.onChange}
                      handleKeyCommand={this.handleKeyCommand}
                      placeholder="Your summary here ..."
                    />
                  </div>
                </div>
              </div>

              <div className="text-right mt-4">
                <button className="btn btn-danger rounded-pill pl-4 pr-4 font-weight-bolder text-capitalize">
                  Save Profile
                  <div
                    className="spinner-border spinner-border-sm ml-2"
                    role="status"
                  >
                    <span className="sr-only">Loading...</span>
                  </div>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    );
  }
}

export default Profile;
