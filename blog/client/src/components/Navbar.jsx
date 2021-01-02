import { React, Component } from "react";
import profile from "./../img/profile.jpg";

class Navbar extends Component {
  state = {};
  constructor(props) {
    super(props);
  }

  render() {
    return (
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" id="sideNav">
            <a class="navbar-brand js-scroll-trigger" href="#page-top">
                <span class="d-block d-lg-none">Clarence Taylor</span>
                <span class="d-none d-lg-block"><img class="img-fluid img-profile rounded-circle mx-auto mb-2" src={profile} alt="" /></span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#welcome">Welcome</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#projects">Projects</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#summary">Summary</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#latest-posts">Latest Posts</a></li>
                    <li class="nav-item"><a class="nav-link js-scroll-trigger" href="#highlights">Highlights</a></li>
                </ul>
            </div>
        </nav>
    );
  }
}

export default Navbar;
