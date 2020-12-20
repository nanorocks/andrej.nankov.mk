import React, { useState } from "react";
import { BrowserRouter, Route, Switch } from "react-router-dom";
import PrivateRoute from "./helpers/PrivateRoute";
import { AuthContext } from "./helpers/context/auth";
import Login from "./pages/Login/Login";
import Dashboard from "./pages/Dashboard/Dashboard";
import Home from "./pages/Dashboard/Home/Home";
import About from "./pages/Dashboard/About/About";
import Blog from "./pages/Dashboard/Blog/Blog";
import Projects from "./pages/Dashboard/Projects/Projects";

function App(props) {
  const existingTokens = JSON.parse(localStorage.getItem("tokens"));
  const [authTokens, setAuthTokens] = useState(existingTokens);

  const setTokens = (data) => {
    localStorage.setItem("tokens", JSON.stringify(data));
    setAuthTokens(data);
  };

  return (
    <div>
      <AuthContext.Provider value={{ authTokens, setAuthTokens: setTokens }}>
        <BrowserRouter>
          <Switch>
            <Route exact path="/" component={Login}>
            </Route>
            <PrivateRoute path="/home" component={Home}>
            </PrivateRoute>
            <PrivateRoute path="/blog" component={Blog}>
            </PrivateRoute>
            <PrivateRoute path="/project" component={Projects}>
            </PrivateRoute>
            <PrivateRoute path="/about" component={About}>
            </PrivateRoute>
            <PrivateRoute path="/dashboard" component={Dashboard}>
            </PrivateRoute>
          </Switch>
        </BrowserRouter>
      </AuthContext.Provider>
    </div>
  );
}

export default App;
