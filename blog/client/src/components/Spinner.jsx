import { Component } from "react";

class Spinner extends Component {
  render() {
    return (
      <div
        className={
          this.props.color
            ? "spinner-grow " + this.props.color
            : "spinner-grow"
        }
        role="status"
      >
        <span className="sr-only">Loading...</span>
      </div>
    );
  }
}

export default Spinner;
