import { Route, Redirect } from "react-router-dom";
import { Token } from "./../services/_index";
import { RouteMapper } from "./../config/_index";

export default function PrivateRoute({ children, ...rest }) {
  return (
    <Route
      {...rest}
      render={({ location }) =>
        Token.get() !== null &&
        children.type.name.toLowerCase() !== RouteMapper.login ? (
          children
        ) : (
          <Redirect
            to={{
              pathname: RouteMapper.login,
              state: { from: location },
            }}
          />
        )
      }
    />
  );
}
