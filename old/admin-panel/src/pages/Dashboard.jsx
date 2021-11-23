import { Component, React } from "react";
import { Profile } from "../components/_index";

class Dashboard extends Component {
  render() {
    return (
      <div>
        <div className="container">
          <Profile />
        </div>
      </div>
    );
  }
}

export default Dashboard;
