import { Component, React } from "react";
import { Helmet } from "react-helmet";
import LazyLoad from "react-lazyload";
import "./App.css";
import {
  Navbar,
  Welcome,
  Summary,
  Highlights,
  Posts,
  Projects,
} from "./components/_index";
import { mapper } from "./config/mapper";
import { read } from "./services/apiReader";
import { Fade } from "react-awesome-reveal";

class App extends Component {
  state = {
    intro: "",
    email: "",
    socMedia: "",
    name: "",
    phone: "",
    address: "",
    quotes: "",
    highlights: "",
  };

  componentDidMount() {
    read(mapper.getCv)
      .then((result) => {
        this.setState({ intro: result.data.intro });
        this.setState({ email: result.data.email });
        this.setState({ socMedia: result.data.socMedia });
        this.setState({ name: result.data.name });
        this.setState({ phone: result.data.phone });
        this.setState({ address: result.data.address });
        this.setState({ quotes: result.data.quotes });
        this.setState({ highlights: result.data.highlights });
      })
      .catch((error) => {
        console.log(error);
      });
  }

  render() {
    return (
      <div>
        {/* <Helmet>
          <meta charSet="utf-8" />
          <title>My Title</title>
          <link rel="canonical" href="http://mysite.com/example" />
        </Helmet> */}

        <Navbar email={this.state.email} name={this.state.name} />
        <Fade delay={180}>
          <Welcome
            intro={this.state.intro}
            email={this.state.email}
            socMedia={this.state.socMedia}
            name={this.state.name}
            phone={this.state.phone}
            address={this.state.address}
            quotes={this.state.quotes}
          />
          <hr class="m-0" />
          <LazyLoad>
            <Projects />
            <hr class="m-0" />
          </LazyLoad>
        <Posts />
        <hr class="m-0" />
        <Summary />
        <hr class="m-0" />
        <Highlights highlights={this.state.highlights} />
        </Fade>
      </div>
    );
  }
}

export default App;
