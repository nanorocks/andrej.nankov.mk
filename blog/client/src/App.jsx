import { Component, React } from "react";
import { Helmet } from "react-helmet";
import "./App.css";
import {
  Navbar,
  Welcome,
  Summary,
  Highlights,
  Posts,
  Projects,
} from "./components/_index";

import { read } from "./services/apiReader";

class App extends Component {
  state = {};
  constructor(props) {
    super(props);
  }

  componentDidMount(){
    read().then(result => {
      console.log(result.data);
    }).catch(error => {
      console.log(error);
    });
  }

  render() {
    return (
      <div>
        <Helmet>
          <meta charSet="utf-8" />
          <title>My Title</title>
          <link rel="canonical" href="http://mysite.com/example" />
        </Helmet>
        <Navbar />
        <Welcome />
        <hr class="m-0" />
        <Projects />
        <hr class="m-0" />
        <Summary />
        <hr class="m-0" />
        <Posts />
        <hr class="m-0" />
        <Highlights />
      </div>
    );
  }
}

export default App;
