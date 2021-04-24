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
import Navbar from "./components/Navbar";

function App() {
  return (
    <Router>
      <div>
          <Navbar></Navbar>
        <Switch>
          <Route exact path="/">
            <Redirect to="/login" />
          </Route>
          <GuestRoute exact path="/login" component={Login}></GuestRoute>
          <PrivateRoute
            exact
            path="/dashboard"
            component={Dashboard}
          >
          </PrivateRoute>

          <PrivateRoute exact path="/configs" component={Config}></PrivateRoute>
          <PrivateRoute
            exact
            path="/configs/new"
            component={NewConfig}
          ></PrivateRoute>
          <PrivateRoute
            exact
            path="/configs/:id"
            component={EditConfig}
          ></PrivateRoute>

          <PrivateRoute exact path="/posts" component={Post}></PrivateRoute>
          <PrivateRoute
            exact
            path="/posts/new"
            component={NewPost}
          ></PrivateRoute>
          <PrivateRoute
            exact
            path="/posts/:id"
            component={EditPost}
          ></PrivateRoute>

          <PrivateRoute
            exact
            path="/projects"
            component={Project}
          ></PrivateRoute>
          <PrivateRoute
            exact
            path="/projects/new"
            component={NewProject}
          ></PrivateRoute>
          <PrivateRoute
            exact
            path="/projects/:id"
            component={EditProject}
          ></PrivateRoute>
          <PrivateRoute exact path="/logout" component={Logout}></PrivateRoute>
          <Route exact path="">
            <ErrorPage title="" description="Page not found!!!"></ErrorPage>
          </Route>
        </Switch>
      </div>
    </Router>
  );
}

export default App;
