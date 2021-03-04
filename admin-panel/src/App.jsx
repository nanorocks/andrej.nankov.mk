import { BrowserRouter as Router, Switch, Route } from "react-router-dom";
import { Navbar } from "./components/_index";
import { Login, Logout, Dashboard, ErrorPage } from "./pages/_index"
import { PrivateRoute, GuestRoute } from "./config/_index";

function App() {
  return (
    <Router>
      <div>
        <Navbar />
        <Switch>
          <GuestRoute exact path="/login">
            <Login></Login>
          </GuestRoute>
          <PrivateRoute exact path="/dashboard">
            <Dashboard></Dashboard>
          </PrivateRoute>
          <PrivateRoute exact path="/logout">
            <Logout></Logout>
          </PrivateRoute>
          <Route exact path="">
            <ErrorPage></ErrorPage>
          </Route>
        </Switch>
      </div>
    </Router>
  );
}

export default App;
