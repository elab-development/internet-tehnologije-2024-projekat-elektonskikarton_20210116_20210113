import { Fragment, useState } from "react";
import { Container, Form, Button, Alert } from "react-bootstrap";
import axiosClient from "../../axios/axios-client";

export default function DodajSestru() {
  const [userId, setUserId] = useState("");
  const [error, setError] = useState("");
  const [success, setSuccess] = useState("");

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError("");
    setSuccess("");

    if (!userId) {
      setError("Polje za ID korisnika je obavezno!");
      return;
    }

    try {
      await axiosClient.post("/sestre", {
        "user_id": userId,
      });
      setSuccess("Sestra uspešno dodata!");
      setUserId("");
    } catch (error) {
      setError("Došlo je do greške prilikom dodavanja sestre.");
      console.error(error);
    }
  };

  return (
    <Fragment>
      <Container fluid={true} className="mainBanner  pt-5">
        <h2>Dodaj novu sestru</h2>

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

          <Button variant="primary" type="submit">
            Dodaj sestru
          </Button>
        </Form>
      </Container>
    </Fragment>
  );
}
