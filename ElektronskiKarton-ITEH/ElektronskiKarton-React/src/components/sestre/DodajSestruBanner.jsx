import { Fragment, useState } from "react";
import { Container, Form, Button, Alert } from "react-bootstrap";
import axiosClient from "../../axios/axios-client";

export default function DodajSestru() {
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");
  const [success, setSuccess] = useState("");

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError("");
    setSuccess("");

    // Provera da li su svi podaci uneti
    if (!name || !email || !password) {
      setError("Sva polja su obavezna!");
      return;
    }

    try {
      // Slanje podataka na server
      const response = await axiosClient.post("/sestre", {
        name,
        email,
        password,
      });

      // Ako je sestra uspešno dodata, prikazujemo poruku o uspehu
      setSuccess(response.data.message);
      setName("");
      setEmail("");
      setPassword("");
    } catch (error) {
      // U slučaju greške, prikazujemo poruku o grešci
      setError("Došlo je do greške prilikom dodavanja sestre.");
      console.error(error);
    }
  };

  return (
    <Fragment>
      <Container fluid={true} className="mainBanner pt-5">
        <h2>Dodaj novu sestru</h2>

        <Form onSubmit={handleSubmit} className="mt-3 azurirajForma">
          {error && <Alert variant="danger">{error}</Alert>}
          {success && <Alert variant="success">{success}</Alert>}

          {/* Polje za ime */}
          <Form.Group controlId="name" className="mb-3">
            <Form.Label className="text-light">Ime sestre</Form.Label>
            <Form.Control
              type="text"
              placeholder="Unesite ime sestre"
              value={name}
              onChange={(e) => setName(e.target.value)}
            />
          </Form.Group>

          {/* Polje za email */}
          <Form.Group controlId="email" className="mb-3">
            <Form.Label className="text-light">Email sestre</Form.Label>
            <Form.Control
              type="email"
              placeholder="Unesite email sestre"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
            />
          </Form.Group>

          {/* Polje za lozinku */}
          <Form.Group controlId="password" className="mb-3">
            <Form.Label className="text-light">Lozinka</Form.Label>
            <Form.Control
              type="password"
              placeholder="Unesite lozinku"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
            />
          </Form.Group>

          {/* Dugme za slanje forme */}
          <Button className="w-100" variant="primary" type="submit">
            Dodaj sestru
          </Button>
        </Form>
      </Container>
    </Fragment>
  );
}
