import { Route, Redirect } from "react-router-dom";
import { Token } from "./../services/_index";
import { RouteMapper } from "./../config/_index";
import { Fragment } from "react";
import Navbar from "../components/Navbar";

export default function PrivateRoute({ component: Component, ...rest }) {
  return (
    <Route
      {...rest}
      render={(props) => (
        <Fragment>
          {Token.get() !== null ? (
            <Fragment>
              <Navbar></Navbar>
              <Component {...props} key={props.location.key} />
            </Fragment>
          ) : (
            <Redirect
              to={{
                pathname: RouteMapper.login,
                state: { from: props },
              }}
            />
          )}
        </Fragment>
      )}
    />
  );
}
