/* eslint-disable jsx-a11y/anchor-is-valid */
import { Component, React } from "react";
import { ImBin, ImUserPlus } from "react-icons/im";
import Alert from "../components/Alert";

class KeyValue extends Component {
  constructor(props) {
    super(props);
    this.state = {
      newKey: "",
      toggleStorageInput: false,
    };

    this.keyValueInputs = this.props.inputs;
  }

  handleNewLink = (e) => {
    const { newKey: key } = this.state;

    if (key === undefined || key === null || key === "") {
      Alert("warning", "You must add key name !!!");
      return;
    }

    if (Object.keys(this.keyValueInputs).includes(key)) {
      Alert("warning", "Key with name " + key + " must be unique !!!");
      return;
    }

    const keyValueInputsBag = this.keyValueInputs;
    keyValueInputsBag[key] = "#";

    this.props.onChangeState(keyValueInputsBag);
    this.setState({ newKey: "" });
  };

  handleValueChange = (name, value) => {
    const keyValueInputsBag = this.keyValueInputs;
    keyValueInputsBag[name] = value;

    this.props.onChangeState(keyValueInputsBag);
  };

  deleteLink = (keyT) => {
    const result = {};
    Object.keys(this.keyValueInputs).forEach((key, i) => {
      if (key !== keyT) {
        result[key] = this.keyValueInputs[key];
      }
    });

    this.keyValueInputs = result;
    this.props.onChangeState(result);
  };

  render() {
    return (
      <div className="row">
        {Object.keys(this.keyValueInputs).map((key, index) => {
          return (
            <div className="col-md-4" key={index}>
              <input
                type="text"
                className="form-control form-control-sm mb-1"
                placeholder="Key"
                value={key}
                readOnly
              />
              <input
                type="text"
                className="form-control form-control-sm"
                placeholder="Link"
                value={this.keyValueInputs[key]}
                onChange={(e) => this.handleValueChange(key, e.target.value)}
              />
              <div className="text-right text-danger small mb-2">
                <ImBin onClick={() => this.deleteLink(key)} />
              </div>
            </div>
          );
        })}

        <div className="col-12">
          <div className="form-inline">
            <input
              type="text"
              className="form-control form-control-sm mb-0 mr-2"
              placeholder="Key"
              value={this.state.newKey}
              onChange={(e) => this.setState({ newKey: e.target.value })}
              required
            />
            <button
              type="button"
              className="btn btn-sm btn-danger rounded-pill"
              onClick={(e) => this.handleNewLink(e)}
            >
              New <ImUserPlus />
            </button>
          </div>
        </div>
        <div className="col-12 mt-2 small text-muted">
          <a
            className="font-italic text-danger small text-decoration-underline"
            onClick={() =>
              this.setState({ toggleStorageInput: !this.state.toggleStorageInput })
            }
          >
            Toggle storage input
          </a>
          <br />
          <span className={this.state.toggleStorageInput ? "" : "d-none"}>
            {JSON.stringify(this.props.inputs)}
          </span>
          <hr />
        </div>
      </div>
    );
  }
}

export default KeyValue;
