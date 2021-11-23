import {
  Route,
  Redirect,
} from "react-router-dom";
import { Token } from "../services/_index";
import { RouteMapper } from "./RouteMapper";

export default function GuestRoute({ children, ...rest }) {
  if (Token.get() !== null) {
    return <Redirect to={RouteMapper.dashboard}></Redirect>;
  }
  
  return (
    <Route
      {...rest}
      render={({ location }) =>
          children
      }
    />
  );
}
