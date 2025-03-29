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
  let { token, user, setUser, setToken } = useStateContext();

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
    // Logika za ažuriranje korisničkog stanja
    if (user) {
      console.log("Korisnik je: ", user);
    }
    window.addEventListener("scroll", onScroll);

    return () => {
      window.removeEventListener("scroll", onScroll); // Čišćenje event listenera kada komponenta bude uklonjena
    };
  }, [user]); // Ako se `user` promeni, `useEffect` se ponovo pokreće

  return (
    <Navbar
      collapseOnSelect
      expand="lg"
      fixed="top"
      className={navBarBackground}
    >

      <Container className={navBarItem}>
        <Navbar.Brand
          href={`${token != null ? "/pocetna" : "/dashboard"}`}
          className={navBarTitle}
        >
          Medical support 
        </Navbar.Brand>
        <Navbar.Toggle aria-controls="responsive-navbar-nav" />
        <Navbar.Collapse id="responsive-navbar-nav">
          <Nav className="ms-auto gap-3">
            {!token ? (
              <>
                <NavLink to="/ustanoveGuest" className={navBarItem}>
                  Ustanove
                </NavLink>
                <NavLink to="/login" className={navBarItem}>
                  Prijavi se
                </NavLink>
                <NavLink to="/register" className={navBarItem}>
                  Registruj se
                </NavLink>
              </>
            ) : (
              <>
                {user.role === "pacijent" && (
                  <>
                    <NavLink to={`/pacijent/${user.id}`} className={navBarItem}>
                      Moji podaci
                    </NavLink>
                    <NavLink to={`/karton/${user.id}`} className={navBarItem}>
                      Karton
                    </NavLink>
                  </>
                )}
                {user.role === "sestra" && (
                  <>
                    <NavLink to="/pacijenti" className={navBarItem}>
                      Pacijenti
                    </NavLink>
                    <NavLink to="/kreiraj-karton" className={navBarItem}>
                      Kreiraj karton
                    </NavLink>
                  </>
                )}
                {user.role === "doktor" && (
                  <>
                    <NavLink to="/kreiraj-pregled" className={navBarItem}>
                      Kreiraj pregled
                    </NavLink>
                  </>
                )}
                {user.role === "admin" && (
                  <>
                    <NavLink to="/doktori" className={navBarItem}>
                      Doktori
                    </NavLink>
                    <NavLink to="/sestre" className={navBarItem}>
                      Sestre
                    </NavLink>
                    <NavLink to="/ustanove" className={navBarItem}>
                      Ustanove
                    </NavLink>
                  </>
                )}
                <NavLink onClick={handleLogout} className={navBarItem}>
                  Odjavi se
                </NavLink>
              </>
            )}
          </Nav>
        </Navbar.Collapse>
      </Container>
    </Navbar>
  );
}
