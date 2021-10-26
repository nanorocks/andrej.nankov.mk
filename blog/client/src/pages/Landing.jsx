import { Component, React } from "react";
import {
  Navbar,
  Welcome,
  Summary,
  Highlights,
} from "./../components/_index";
import { mapper } from "./../config/mapper";
import { read } from "./../services/apiReader";
import { withRouter } from "react-router-dom";
import AnchorLink from "react-anchor-link-smooth-scroll";
import Posts from "../components/functions/Posts";
import Projects from "../components/functions/Projects";

class Landing extends Component {
  state = {
    spinner: false,
    intro: "",
    photo: "",
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
    this.setState({ spinner: true });
    read(mapper.getCv)
      .then((result) => {
        const {
          intro,
          photo,
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
          photo,
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

        setTimeout(() => {
          this.setState({ spinner: false });
        }, 200);

      })
      .catch((error) => {
        console.log(error);
        this.props.history.push("/500");
      });
  }

  render() {
    return (
      <div>
        <Navbar
          email={this.state.email}
          name={this.state.name}
          photo={this.state.photo}
        />
        <Welcome
          intro={this.state.intro}
          email={this.state.email}
          socMediaKeys={Object.keys(this.state.socMedia)}
          socMediaValues={Object.values(this.state.socMedia)}
          name={this.state.name}
          phone={this.state.phone}
          address={this.state.address}
          quotes={this.state.quotes}
          spinner={this.state.spinner}
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
          spinner={this.state.spinner}
        />
        <hr className="m-0" />
        <Highlights highlights={this.state.highlights} />
        <footer className="text-right mb-4">
          <AnchorLink
            href="#welcome"
            id="scrollToTopBtn"
            className="p-3 m-2 mb-4"
          >
            ☝️
          </AnchorLink>
        </footer>
      </div>
    );
  }
}

export default withRouter(Landing);
