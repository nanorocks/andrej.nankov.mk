import React from "react";
import OffcanvasMenu from "react-offcanvas-menu-component";
import { Link } from "react-router-dom";

function Navbar({ location, menu, header }) {
  return (
    <OffcanvasMenu
      Link={Link}
      location={location}
      config={{
        width: 300,
        push: true,
        skin: "dark",
      }}
      menu={menu}
      header={header}
      footer={<Footer />}
    />
  );
}

const Footer = () => {
  return (
    <div className="social-wrap">
      <h4>Socia Networks Footer</h4>
      <ul className="social">
        <li>
          <a href="facebook">Facebook</a>
        </li>
        <li>
          <a href="twitter">Twitter</a>
        </li>
      </ul>
    </div>
  );
};

export default Navbar;
