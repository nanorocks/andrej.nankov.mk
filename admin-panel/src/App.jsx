import {
  BrowserRouter as Router,
  Switch,
  Route,
  Redirect,
} from "react-router-dom";
import {
  Login,
  Logout,
  Dashboard,
  ErrorPage,
  Config,
  EditConfig,
  NewConfig,
  Post,
  EditPost,
  NewPost,
  Project,
  EditProject,
  NewProject,
} from "./pages/_index";
import { PrivateRoute, GuestRoute } from "./config/_index";

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
          {/* Configs */}
          <PrivateRoute exact path="/configs">
            <Config></Config>
          </PrivateRoute>
          <PrivateRoute exact path="/configs/new">
            <NewConfig></NewConfig>
          </PrivateRoute>
          <PrivateRoute exact path="/configs/:id">
            <EditConfig></EditConfig>
          </PrivateRoute>

          <PrivateRoute exact path="/posts">
            <Post></Post>
          </PrivateRoute>
          <PrivateRoute exact path="/posts/new">
            <NewPost></NewPost>
          </PrivateRoute>
          <PrivateRoute exact path="/posts/:id">
            <EditPost></EditPost>
          </PrivateRoute>

          <PrivateRoute exact path="/projects">
            <Project></Project>
          </PrivateRoute>
          <PrivateRoute exact path="/projects/new">
            <NewProject></NewProject>
          </PrivateRoute>
          <PrivateRoute exact path="/projects/:id">
            <EditProject></EditProject>
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
