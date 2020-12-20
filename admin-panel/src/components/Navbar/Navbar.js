import React from "react";
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
import { Link } from "react-router-dom";
import { useAuth } from "../../helpers/context/auth";

function Navbar() {
  const { setAuthTokens } = useAuth();
  const token = JSON.parse(localStorage.getItem("tokens")) === false ? false : true;

  function logOut() {
    setAuthTokens(false);
  }

  function auth(token) {
    if (!token) {
      return (
        <Button colorScheme="teal" mr="4">
          <Link to="/">Login</Link>
        </Button>
      );
    }
    return (
      <Button colorScheme="teal" mr="4" onClick={logOut}>
        Logout
      </Button>
    );
  }

  return (
    <Box bg="teal.300" w="100%" p={2} boxShadow="base">
      <Flex>
        <Box p="2">
          <Heading size="md">Admin panel</Heading>
        </Box>
        <Spacer />
        <Box>
          {auth(token)}
          <Button colorScheme="teal" mr="4">
            <Link to="/dashboard">Dashboard</Link>
          </Button>
          <Menu mt={2}>
            <MenuButton
              as={Button}
              rightIcon={<DragHandleIcon />}
              colorScheme="teal"
            >
              Menu
            </MenuButton>
            <MenuList>
              <Link to="/home">
                <MenuItem>Home</MenuItem>
              </Link>

              <Link to="/about">
                <MenuItem>About</MenuItem>
              </Link>

              <Link to="/blog">
                <MenuItem>Blog</MenuItem>
              </Link>
              <Link to="/project">
                <MenuItem>Project</MenuItem>
              </Link>
            </MenuList>
          </Menu>
        </Box>
      </Flex>
    </Box>
  );
}

export default Navbar;
