import logo from "./logo.svg";
import "./App.css";
import { BrowserRouter as Router, Switch, Route, Link } from "react-router-dom";
import NavComponent from "./_components/layout/nav.component";

function App() {
  return (
    <div className="App">
        <NavComponent />
    </div>
  );
}

export default App;
