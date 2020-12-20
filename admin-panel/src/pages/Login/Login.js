import React, { useState } from "react";
import { Link, Redirect, useHistory } from "react-router-dom";
import axios from 'axios';
import { Card, Logo, Form, Input, Button, Error } from '../../globals/styled-components';
import { useAuth } from "../../helpers/context/auth";

function Login(props) {

  const token = JSON.parse(localStorage.getItem("tokens")) === false ? false : true;
  const [isLoggedIn, setLoggedIn] = useState(token);
  const [isError, setIsError] = useState(false);
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const { setAuthTokens } = useAuth();
  const history = useHistory();

  function postLogin() {
    

    axios.defaults.headers.post['Access-Control-Allow-Origin'] = '*';
    axios.post("http://blog-api.repo/login", {
      email,
      password
    }).then(result => {
      console.log(result)
      if (result.status === 200) {
        
        setAuthTokens(result.data);
        setLoggedIn(true);
        
        history.push('/dashboard');

      } else {
        setIsError(true);
      }
    }).catch(e => {
      setIsError(true);
    });
  }

  const referer = props.location.state ? props.location.state.referer : '/dashboard';
  console.log(isLoggedIn, referer);
  if (isLoggedIn) {
    return <Redirect to={referer} />;
  }


  return (
    <Card>
      <Form>
        <Input
          type="email"
          value={email}
          onChange={e => {
            setEmail(e.target.value);
          }}
          placeholder="email"
        />
        <Input
          type="password"
          value={password}
          onChange={e => {
            setPassword(e.target.value);
          }}
          placeholder="password"
        />
        <Button onClick={postLogin}>Sign In</Button>
      </Form>
        { isError &&<Error>The username or password provided were incorrect!</Error> }
    </Card>
  );
}

export default Login;