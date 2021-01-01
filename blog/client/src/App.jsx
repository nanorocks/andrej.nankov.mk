import { Component, React } from "react";
import logo from "./logo.svg";
import "./App.css";
import { Navbar, About, Experience, Education, Skills, Interests, Awards } from "./components/_index";


class App extends Component {
  state = {};
  constructor(props) {
    super(props);
  }

  render() {
    return (
    <div>
      <Navbar />
      <About />
      <hr class="m-0" />
      <Experience />
      <hr class="m-0" />
      <Education />
      <hr class="m-0" />
      <Skills />
      <hr class="m-0" />
      <Interests />
      <hr class="m-0" />
      <Awards />
    </div>
    )
  }
}

export default App;
