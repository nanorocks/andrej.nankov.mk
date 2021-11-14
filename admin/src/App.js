import "./App.css";
import Dashboard from "./_pages/Dashboard";
import Posts from "./_pages/Posts";
import Projects from "./_pages/Projects";
import { Routes, Route } from "react-router-dom";
import Navbar from "./_organisms/Navbar";

function App() {
  return (
    <div className="App">
      <Navbar></Navbar>
      <Routes>
        <Route path="/" element={<Dashboard />} />
        <Route path="posts" element={<Posts />} />
        <Route path="projects" element={<Projects />} />
      </Routes>
    </div>
  );
}

export default App;
