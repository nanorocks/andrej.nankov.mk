import { Component, React } from "react";
import "./App.css";
import { BrowserRouter as Router, Switch, Route } from "react-router-dom";
import { Landing, SinglePost, ErrorPage } from "./pages/_index";
import "./services/GoogleAnalytics";

class App extends Component {
  render() {
    return (
      <Router>
        <Switch>
          <Route exact path="/" component={Landing} />
          <Route path="/post/:uuid" component={SinglePost} />
          <Route path="/500">
            <ErrorPage
              title={500}
              description={"Internal server error."}
            ></ErrorPage>
          </Route>
          <Route path="">
            <ErrorPage
              title={404}
              description={"The Page can't be found"}
            ></ErrorPage>
          </Route>
        </Switch>
      </Router>
    );
  }
}

export default App;
