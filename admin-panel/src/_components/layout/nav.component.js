import {
  Menu,
  MenuButton,
  MenuList,
  MenuItem,
  Button,
  Box,
  Heading,
  Flex,
  Spacer,
} from "@chakra-ui/react";
import { DragHandleIcon } from "@chakra-ui/icons";
import AboutPage from "../../_pages/about.page";
import HomePage from "../../_pages/home.page";
import ProjectsPage from "../../_pages/projects.page";
import BlogPage from "../../_pages/blog.page";
import { BrowserRouter as Router, Switch, Route, Link } from "react-router-dom";
import LoginPage from "../../_pages/login.page";

export default function NavComponent() {
  return (
    <Router>
      <Box bg="teal.300" w="100%" p={2} boxShadow="base">
        <Flex>
          <Box p="2">
            <Heading size="md">Admin panel</Heading>
          </Box>
          <Spacer />
          <Box>
            <Button colorScheme="teal" mr="4"><Link to="/login">Login</Link></Button>
            <Menu mt={2}>
              <MenuButton as={Button} rightIcon={<DragHandleIcon />} colorScheme="teal">
                Menu
              </MenuButton>
              <MenuList>
                <Link to="/">
                  <MenuItem>Home</MenuItem>
                </Link>
                <Link to="/about">
                  <MenuItem>About</MenuItem>
                </Link>
                <Link to="/blog">
                  <MenuItem>Blog</MenuItem>
                </Link>
                <Link to="/projects">
                  <MenuItem>Projects</MenuItem>
                </Link>
              </MenuList>
            </Menu>
          </Box>
        </Flex>
      </Box>
      <Switch>
        <Route path="/projects">
          <ProjectsPage />
        </Route>
        <Route path="/blog">
          <BlogPage />
        </Route>
        <Route path="/about">
          <AboutPage />
        </Route>
        <Route path="/login">
          <LoginPage />
        </Route>
        <Route path="/">
          <HomePage />
        </Route>
      </Switch>
    </Router>
  );
}
