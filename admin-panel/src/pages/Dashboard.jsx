import { Component, React } from "react";
import Config from "../components/Config";
import { Profile } from "../components/_index";

class Dashboard extends Component {
  render() {
    return (
      <div>
        <div className="container">
          {/* <Config /> */}
          <Profile />
        </div>
      </div>
    );
  }
}

export default Dashboard;
