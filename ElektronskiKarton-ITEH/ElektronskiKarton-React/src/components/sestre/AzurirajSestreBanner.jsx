import { Fragment, useState, useEffect } from "react";
import { Container, Form, Button, Alert } from "react-bootstrap";
import { useParams, useNavigate } from "react-router-dom";
import axiosClient from "../../axios/axios-client";

export default function AzurirajSestruBanner() {
  const { id } = useParams(); // Preuzimanje ID-a sestre iz URL-a
  const navigate = useNavigate();

  const [userId, setUserId] = useState("");
  const [error, setError] = useState("");
  const [success, setSuccess] = useState("");

  useEffect(() => {
    // Dohvatanje podataka o sestri
    const fetchSestra = async () => {
      try {
        const response = await axiosClient.get(`sestra/${id}`);
        const sestra = response.data.data;
        setUserId(sestra.user_id);
      } catch (error) {
        setError("Došlo je do greške prilikom učitavanja podataka o sestri.");
        console.error(error);
      }
    };

    fetchSestra();
  }, [id]);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError("");
    setSuccess("");

    if (!userId) {
      setError("Polje ID korisnika je obavezno!");
      return;
    }

    try {
      await axiosClient.put(`/sestre/${id}`, {
        user_id: userId,
      });
      setSuccess("Podaci o sestri uspešno ažurirani!");
      setTimeout(() => navigate("/sestre"), 2000); // Redirekcija nakon uspeha
    } catch (error) {
      setError("Došlo je do greške prilikom ažuriranja sestre.");
      console.error(error);
    }
  };

  return (
    <Fragment>
      <Container fluid={true} className="mainBanner pt-5">
        <h2>Izmeni podatke o sestri</h2>

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
            Ažuriraj sestru
          </Button>
        </Form>
      </Container>
    </Fragment>
  );
}
