import './App.css';
import { BrowserRouter as Router, Switch, Route } from "react-router-dom";
import { Navbar } from "./components/_index";
import { Login, Logout, Dashboard, ErrorPage } from "./pages/_index"

function App() {
  return (
    <Router>
      <div>
        <Navbar />
        <Switch>
          <Route exact path="/">
            <Login></Login>
          </Route>
          <Route exact path="/dashboard">
            <Dashboard></Dashboard>
          </Route>
          <Route exact path="/logout">
            <Logout></Logout>
          </Route>
          <Route exact path="">
            <ErrorPage></ErrorPage>
          </Route>
        </Switch>
      </div>
    </Router>
  );
}

export default App;
