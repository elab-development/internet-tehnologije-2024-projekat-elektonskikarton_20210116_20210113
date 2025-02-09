import { Fragment, useState, useEffect } from "react";
import { Container, Form, Button, Alert } from "react-bootstrap";
import { useParams, useNavigate } from "react-router-dom";
import axiosClient from "../../axios/axios-client";

export default function AzurirajDoktoraBanner() {
  const { id } = useParams(); // Preuzimanje ID-a doktora iz URL-a
  const navigate = useNavigate();
  const [userid, setUserid] = useState("");
  const [specijalizacija, setSpecijalizacija] = useState("");
  const [error, setError] = useState("");
  const [success, setSuccess] = useState("");

  useEffect(() => {
    // Dohvatanje podataka o doktoru
    const fetchDoktor = async () => {
      try {
        const response = await axiosClient.get(`doktor/${id}`);
        const doktor = response.data.data;
        setUserid(doktor.user_id);
        setSpecijalizacija(doktor.specijalizacija);
      } catch (error) {
        setError("Došlo je do greške prilikom učitavanja doktora.");
        console.error(error);
      }
    };

    fetchDoktor();
  }, [id]);

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError("");
    setSuccess("");


    try {
      await axiosClient.put(`/doktori/${id}`, {
        userid,
        specijalizacija,
      });
      setSuccess("Podaci o doktoru uspešno ažurirani!");
      setTimeout(() => navigate("/doktori"), 2000); // Redirekcija nakon uspeha
    } catch (error) {
      setError("Došlo je do greške prilikom ažuriranja doktora.");
      console.error(error);
    }
  };

  return (
    <Fragment>
      <Container fluid={true} className="mainBanner pt-5">
        <h2>Izmeni podatke o doktoru</h2>

        <Form onSubmit={handleSubmit} className="azurirajForma pt-3">
          {error && <Alert variant="danger">{error}</Alert>}
          {success && <Alert variant="success">{success}</Alert>}


          <Form.Group controlId="specijalizacija" className="mb-3 text-light">
            <Form.Label>Specijalizacija</Form.Label>
            <Form.Control
              type="text"
              placeholder="Unesite specijalizaciju"
              value={specijalizacija}
              onChange={(e) => setSpecijalizacija(e.target.value)}
            />
          </Form.Group>

          <Button variant="primary" type="submit" className="w-100">
            Ažuriraj doktora
          </Button>
        </Form>
      </Container>
    </Fragment>
  );
}
