import { useEffect, useState } from "react";
import Container from "react-bootstrap/Container";
import Nav from "react-bootstrap/Nav";
import Navbar from "react-bootstrap/Navbar";
import { NavLink } from "react-router-dom";
import { useStateContext } from "../../context/ContextProvider";

export default function NavBar() {
  const [navBarBackground, setNavBarBackground] = useState("navBackground");
  const [navBarItem, setNavBarItem] = useState("navItem");
  const [navBarTitle, setNavBarTitle] = useState("navTitle");
  const {token, setUser, setToken} = useStateContext();

  const onScroll = () => {
    if (window.scrollY > 50) {
      setNavBarBackground("navBackgroundScroll");
      setNavBarItem("navItemScroll");
      setNavBarTitle("navTitleScroll");
    } else {
      setNavBarBackground("navBackground");
      setNavBarItem("navItem");
      setNavBarTitle("navTitle");
    }
  };

  const handleLogout = () => {
    setUser(null);
    setToken(null);
  };

  useEffect(() => {
    window.addEventListener("scroll", onScroll);
  });

  return (
    <Navbar
      collapseOnSelect
      expand="lg"
      fixed="top"
      className={navBarBackground}
    >
      <Container className={navBarItem}>
        <Navbar.Brand href="#home" className={navBarTitle}>
          Medical support
        </Navbar.Brand>
        <Navbar.Toggle aria-controls="responsive-navbar-nav" />
        <Navbar.Collapse id="responsive-navbar-nav">
          <Nav className="ms-auto">
          {!token ? (
              < >
                <NavLink to="/login" className={navBarItem}>Prijavi se</NavLink>
                <NavLink to="/register" className={navBarItem}>Registruj se</NavLink>
              </>
            ) : (
              <>
                <NavLink onClick={handleLogout} className={navBarItem}>Odjavi se</NavLink>
              </>
            )}
          </Nav>
        </Navbar.Collapse>
      </Container>
    </Navbar>
  );
}
