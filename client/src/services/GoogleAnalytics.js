import ReactGA from "react-ga";

ReactGA.initialize("UA-156917962-1");

ReactGA.pageview(window.location.pathname + window.location.search);
