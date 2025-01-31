import { useEffect, useState } from "react";
import Container from "react-bootstrap/Container";
import Nav from "react-bootstrap/Nav";
import Navbar from "react-bootstrap/Navbar";
import { NavLink } from "react-router-dom";

export default function NavBar() {
  const [navBarBackground, setNavBarBackground] = useState("navBackground");
  const [navBarItem, setNavBarItem] = useState("navItem");
  const [navBarTitle, setNavBarTitle] = useState("navTitle");


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
          <Nav className="me-auto text">
            <NavLink
              to="#"
              className={navBarItem}
              style={({ isActive }) => ({
                color: isActive ? "#22577a" : "white",
              })}
            >
              Lekari
            </NavLink>
            <NavLink
              to="#"
              className={navBarItem}
              style={({ isActive }) => ({
                color: isActive ? "#22577a" : "white",
              })}
            >
              Lokacije
            </NavLink>
            <NavLink
              to="#pricing"
              className={navBarItem}
              style={({ isActive }) => ({
                color: isActive ? "#22577a" : "white",
              })}
            >
              O nama
            </NavLink>
          </Nav>
          <Nav>
            <NavLink to="#deets" className={navBarItem}>Prijavi se</NavLink>
            <NavLink to="#deets" className={navBarItem}>Registruj se</NavLink>
          </Nav>
        </Navbar.Collapse>
      </Container>
    </Navbar>
  );
}
