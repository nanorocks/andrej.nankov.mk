import React from "react";
import { Route, Redirect } from "react-router-dom";
import { useAuth } from "./context/auth";
import Navbar from "./../components/Navbar/Navbar";

function PrivateRoute({ component: Component, ...rest }) {
  const { authTokens } = useAuth();

  return (
    <Route
      {...rest}
      render={props =>
        authTokens ? (
          <div>
          <Navbar></Navbar>
          <Component {...props} />
          </div>
          
        ) : (
          <Redirect to={{ pathname: "/", state: { referer: props.location } }} />
        )
      }
    />
  );
}

export default PrivateRoute;