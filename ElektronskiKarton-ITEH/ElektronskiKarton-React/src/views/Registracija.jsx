/* eslint-disable no-unused-vars */
import { Fragment, useState, useEffect } from "react";
import { Col, Container } from "react-bootstrap";
import { Link } from "react-router-dom";
import { useStateContext } from "../context/ContextProvider";
import { useNavigate } from "react-router-dom";
import axiosClient from "../axios/axios-client";
import 'bootstrap/dist/css/bootstrap.min.css';


export default function Registracija() {
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [passwordConfirm, setPasswordConfirm] = useState("");
  const [jmbg, setJmbg] = useState("");
  const [imePrezimeNZZ, setImePrezimeNZZ] = useState("");
  const [datumRodjenja, setDatumRodjenja] = useState("");
  const [ulicaBroj, setUlicaBroj] = useState("");
  const [telefon, setTelefon] = useState("");
  const [pol, setPol] = useState("");
  const [bracniStatus, setBracniStatus] = useState("");
  const [mesto_postanskiBroj, setMestoPB] = useState("");
  const [postanskiBrojevi, setPostanskiBrojevi] = useState([]); // For dropdown
  const [error, setError] = useState("");
  const { setUser } = useStateContext();
  const navigate = useNavigate();

  // Fetch postal codes from the backend
  useEffect(() => {
    axiosClient
      .get("/mestaPB") // Replace with your API endpoint
      .then((response) => {
        setPostanskiBrojevi(response.data);
      })
      .catch((err) => {
        console.error("Failed to fetch postal codes:", err);
      });
  }, []);

  const handleSubmit = async (e) => {
    e.preventDefault();

    // Regex validations
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const jmbgRegex = /^\d{13}$/;
    const telefonRegex = /^\+381 \d{9}$/;

    if (
      !email ||
      !password ||
      !name ||
      !passwordConfirm ||
      !imePrezimeNZZ ||
      !datumRodjenja ||
      !ulicaBroj ||
      !telefon ||
      !pol ||
      !bracniStatus ||
      !mesto_postanskiBroj
    ) {
      setError("Molimo popunite sva polja");
      return;
    }

    if (!emailRegex.test(email)) {
      setError("Neispravan email format");
      return;
    }

    if (password !== passwordConfirm || password.length < 8) {
    console.log(password);
    console.log(passwordConfirm);
      setError("Lozinka mora imati najmanje 8 karaktera");
      return;
    }

    if (!jmbgRegex.test(jmbg)) {
      setError("JMBG mora imati tačno 13 cifara");
      return;
    }

    if (!telefonRegex.test(telefon)) {
      setError("Telefon mora biti u formatu +381 xx xxx xxxx");
      return;
    }

    try {
      const response = await axiosClient.post("/register", {
        name,
        email,
        password,
        passwordConfirm,
        jmbg,
        imePrezimeNZZ,
        datumRodjenja,
        ulicaBroj,
        telefon,
        pol,
        bracniStatus,
        mesto_postanskiBroj,
      });
      setUser(response.data);
      navigate("/login"); // Redirect to home after successful registration
    } catch (err) {
      setError("Neuspešna registracija, proverite podatke");
    }
  };

  return (
    <Fragment>
  <Container fluid={true} className="guestBackground">
    <form className="loginForm" onSubmit={handleSubmit}>
      <div className="formGrid">
        <Col className="formColumn" lg={6} md ={12} sm={12}>
          <label htmlFor="imePrezime">Ime i prezime</label>
          <input
            type="text"
            id="imePrezime"
            name="imePrezime"
            placeholder="Ime i prezime"
            value={name}
            onChange={(e) => setName(e.target.value)}
          />

          <label htmlFor="email">Email</label>
          <input
            type="text"
            id="email"
            name="email"
            placeholder="Email"
            value={email}
            onChange={(e) => setEmail(e.target.value)}
          />

          <label htmlFor="lozinka">Lozinka</label>
          <input
            type="password"
            id="lozinka"
            name="lozinka"
            placeholder="Lozinka"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
          />

          <label htmlFor="potvrdLozinke">Potvrda lozinke</label>
          <input
            type="password"
            id="potvrdLozinke"
            name="potvrdLozinke"
            placeholder="Potvrda lozinke"
            value={passwordConfirm}
            onChange={(e) => setPasswordConfirm(e.target.value)}
          />

          <label htmlFor="jmbg">JMBG</label>
          <input
            type="text"
            id="jmbg"
            name="jmbg"
            placeholder="JMBG"
            value={jmbg}
            onChange={(e) => setJmbg(e.target.value)}
          />

          <label htmlFor="imePrezimeNZZ">
            Ime i prezime nosioca zdravstvenog osiguranja
          </label>
          <input
            type="text"
            id="imePrezimeNZZ"
            name="imePrezimeNZZ"
            placeholder="Ime i prezime NZZ"
            value={imePrezimeNZZ}
            onChange={(e) => setImePrezimeNZZ(e.target.value)}
          />
        </Col>

        <Col className="formColumn" lg={6} md ={12} sm={12}>
          <label htmlFor="datumRodjenja">Datum rođenja</label>
          <input
            type="date"
            id="datumRodjenja"
            name="datumRodjenja"
            placeholder="YYYY-mm-dd"
            value={datumRodjenja}
            onChange={(e) => setDatumRodjenja(e.target.value)}
          />

          <label htmlFor="ulicaBroj">Ulica i broj</label>
          <input
            type="text"
            id="ulicaBroj"
            name="ulicaBroj"
            placeholder="Ulica i broj"
            value={ulicaBroj}
            onChange={(e) => setUlicaBroj(e.target.value)}
          />

          <label htmlFor="telefon">Broj telefona</label>
          <input
            type="text"
            id="telefon"
            name="telefon"
            placeholder="+381 xx xxx xxxx"
            value={telefon}
            onChange={(e) => setTelefon(e.target.value)}
          />

          <label htmlFor="pol">Pol</label>
          <div>
            <label className="pe-5">
              <input
                type="radio"
                name="pol"
                value="muski"
                checked={pol === "muski"}
                onChange={(e) => setPol(e.target.value)}
              />{" "}
              Muški
            </label>
            <label>
              <input
                type="radio"
                name="pol"
                value="zenski"
                checked={pol === "zenski"}
                onChange={(e) => setPol(e.target.value)}
              />{" "}
              Ženski
            </label>
          </div>

          <label htmlFor="bracniStatus">Bračni status</label>
          <select
            id="bracniStatus"
            name="bracniStatus"
            value={bracniStatus}
            onChange={(e) => setBracniStatus(e.target.value)}
          >
            <option value="">Izaberite status</option>
            <option value="u braku">U braku</option>
            <option value="nije u braku">Nije u braku</option>
          </select>

          <label htmlFor="mestoPB">Mesto i poštanski broj</label>
          <select
            id="mestoPB"
            name="mestoPB"
            value={mesto_postanskiBroj}
            onChange={(e) => setMestoPB(e.target.value)}
          >
            <option value="">Izaberite mesto</option>
            {postanskiBrojevi.map((mesto) => (
              <option key={mesto.id} value={mesto.naziv}>
                {mesto.naziv} {mesto.postanskiBroj}
              </option>
            ))}
          </select>
        </Col>
      </div>

      <div className="errorBox">{error}</div>

      <button className="formButton" type="submit">Registracija</button>
      <div>
        <p className="pt-2">
          Imaš nalog? <Link className="text-primary" to="/login">Prijavi se</Link>
          <p className="pt-2">Nazad na početnu? <Link to="/pocetna">Odustani</Link></p>
        </p>
      </div>
    </form>
  </Container>
</Fragment>

  );
}