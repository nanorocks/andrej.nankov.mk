import { Component, React } from "react";
import {
  Navbar,
  Welcome,
  Summary,
  Highlights,
  Posts,
  Projects,
} from "./../components/_index";
import { mapper } from "./../config/mapper";
import { read } from "./../services/apiReader";
import { withRouter } from "react-router-dom";

class Landing extends Component {
  state = {
    intro: "",
    email: "",
    socMedia: "",
    name: "",
    phone: "",
    address: "",
    quotes: "",
    highlights: "",
    summary: "",
    currentWork: "",
    goals: "",
    topProgrammingLanguages: "",
  };

  componentDidMount() {
    read(mapper.getCv)
      .then((result) => {
        const {
          intro,
          email,
          socMedia,
          name,
          phone,
          address,
          quotes,
          highlights,
          summary,
          currentWork,
          goals,
          topProgrammingLanguages,
        } = result.data;
        this.setState({
          intro,
          email,
          socMedia,
          name,
          phone,
          address,
          quotes,
          highlights,
          summary,
          currentWork,
          goals,
          topProgrammingLanguages,
        });
      })
      .catch((error) => {
        console.log(error);
        this.props.history.push("/500");
      });
  }

  render() {
    return (
      <div>
        <Navbar email={this.state.email} name={this.state.name} />
        <Welcome
          intro={this.state.intro}
          email={this.state.email}
          socMediaKeys={Object.keys(this.state.socMedia)}
          socMediaValues={Object.values(this.state.socMedia)}
          name={this.state.name}
          phone={this.state.phone}
          address={this.state.address}
          quotes={this.state.quotes}
        />
        <hr className="m-0" />
        <Projects />
        <hr className="m-0" />
        <Posts />
        <hr className="m-0" />
        <Summary
          summary={this.state.summary}
          currentWork={this.state.currentWork}
          goals={this.state.goals}
          topProgrammingLanguages={this.state.topProgrammingLanguages}
        />
        <hr className="m-0" />
        <Highlights
          highlightsKeys={Object.keys(this.state.highlights)}
          highlightsValues={Object.values(this.state.highlights)}
        />
      </div>
    );
  }
}

export default withRouter(Landing);
