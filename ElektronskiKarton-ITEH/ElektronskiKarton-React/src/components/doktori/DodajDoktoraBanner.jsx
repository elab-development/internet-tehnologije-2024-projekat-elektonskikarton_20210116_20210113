import { Fragment, useState } from "react";
import { Container, Form, Button, Alert } from "react-bootstrap";
import axiosClient from "../../axios/axios-client";

export default function DodajDoktora() {
  const [userId, setUserId] = useState("");
  const [specijalizacija, setSpecijalizacija] = useState("");
  const [error, setError] = useState("");
  const [success, setSuccess] = useState("");

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError("");
    setSuccess("");

    if (!userId || !specijalizacija) {
      setError("Sva polja su obavezna!");
      return;
    }

    try {
      await axiosClient.post("/doktori", {
        "user_id": userId,
        "specijalizacija": specijalizacija,
      });
      setSuccess("Doktor uspešno dodat!");
      setUserId("");
      setSpecijalizacija("");
    } catch (error) {
      setError("Došlo je do greške prilikom dodavanja doktora.");
      console.error(error);
    }
  };

  return (
    <Fragment>
      <Container fluid={true} className="mainBanner mt-5">
        <h2>Dodaj novog doktora</h2>

        <Form onSubmit={handleSubmit} className="mt-3">
          {error && <Alert variant="danger">{error}</Alert>}
          {success && <Alert variant="success">{success}</Alert>}

          <Form.Group controlId="userId" className="mb-3">
            <Form.Label>ID korisnika (user_id)</Form.Label>
            <Form.Control
              type="number"
              placeholder="Unesite ID korisnika"
              value={userId}
              onChange={(e) => setUserId(e.target.value)}
            />
          </Form.Group>

          <Form.Group controlId="specijalizacija" className="mb-3">
            <Form.Label>Specijalizacija</Form.Label>
            <Form.Control
              type="text"
              placeholder="Unesite specijalizaciju"
              value={specijalizacija}
              onChange={(e) => setSpecijalizacija(e.target.value)}
            />
          </Form.Group>

          <Button variant="primary" type="submit">
            Dodaj doktora
          </Button>
        </Form>
      </Container>
    </Fragment>
  );
}
