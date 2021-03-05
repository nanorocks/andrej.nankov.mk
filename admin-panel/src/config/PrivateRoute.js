import { Route, Redirect } from "react-router-dom";
import { Token } from "./../services/_index";
import { RouteMapper } from "./../config/_index";
import { Fragment } from "react";
import Navbar from "../components/Navbar";

export default function PrivateRoute({ children, ...rest }) {
  return (
    <Route
      {...rest}
      render={({ location }) => (
        <Fragment>
          <Navbar></Navbar>
          {Token.get() !== null && children.type.name.toLowerCase() !==
          RouteMapper.login ? ( children ) : (
          <Redirect
            to={{
              pathname: RouteMapper.login,
              state: { from: location },
            }}
          />
          )}
        </Fragment>
      )}
    />
  );
}
