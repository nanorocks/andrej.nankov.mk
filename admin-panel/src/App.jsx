import { BrowserRouter as Router, Switch, Route, Redirect } from "react-router-dom";
import { Login, Logout, Dashboard, ErrorPage, Config, Post, Project } from "./pages/_index"
import { PrivateRoute, GuestRoute } from "./config/_index";
import { CreateConfig, UpdateConfig } from "./components/_index";

function App() {
  return (
    <Router>
      <div>
        <Switch>
          <Route exact path="/">
            <Redirect to="/login" />
          </Route>
          <GuestRoute exact path="/login">
            <Login></Login>
          </GuestRoute>
          <PrivateRoute exact path="/dashboard">
            <Dashboard></Dashboard>
          </PrivateRoute>
          <PrivateRoute exact path="/configs">
            <Config></Config>
          </PrivateRoute>

          <PrivateRoute exact path="/configs/new">
            <CreateConfig />
          </PrivateRoute>
          <PrivateRoute exact path="/configs/:id">
            <UpdateConfig />
          </PrivateRoute>
          
          <PrivateRoute exact path="/posts">
            <Post></Post>
          </PrivateRoute>
          <PrivateRoute exact path="/projects">
            <Project></Project>
          </PrivateRoute>
          <PrivateRoute exact path="/logout">
            <Logout></Logout>
          </PrivateRoute>
          <Route exact path="">
            <ErrorPage title="" description="Page not found!!!"></ErrorPage>
          </Route>
        </Switch>
      </div>
    </Router>
  );
}

export default App;
