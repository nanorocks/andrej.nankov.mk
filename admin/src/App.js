import "./App.css";
import Dashboard from "./_pages/Dashboard";
import Posts from "./_pages/Posts";
import Projects from "./_pages/Projects";
import { Routes, Route } from "react-router-dom";
import Navbar from "./_organisms/Navbar";

function App() {
  return (
    <div className="App">
      <Navbar
        menu={[
          { text: "Dashboard", link: "/" },
          { text: "Posts", link: "/posts" },
          { text: "Projects", link: "/projects" },
          { text: "Logout", link: "/logout" },
        ]}
        header={
          <img
            src="https://via.placeholder.com/150"
            className="menu-logo"
            alt="logo"
            width="250"
            height="100"
          />
        }
      />
      <Routes>
        <Route path="/" element={<Dashboard />} />
        <Route path="posts" element={<Posts />} />
        <Route path="projects" element={<Projects />} />
      </Routes>
      <ul class="circles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
      </ul>
    </div>
  );
}

export default App;
