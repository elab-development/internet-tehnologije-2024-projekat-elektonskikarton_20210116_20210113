import { Fragment, useState, useEffect } from "react";
import { Container, Form, Button, Alert } from "react-bootstrap";
import { useParams, useNavigate } from "react-router-dom";
import axiosClient from "../../axios/axios-client";

export default function AzurirajSestruBanner() {
  const { id } = useParams(); // Preuzimanje ID-a sestre iz URL-a
  const navigate = useNavigate();

  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [userId, setUserId] = useState("");
  const [error, setError] = useState("");
  const [success, setSuccess] = useState("");

  useEffect(() => {
    const fetchSestra = async () => {
      try {
        const response = await axiosClient.get(`sestra/${id}`);
        const sestra = response.data; // Ako je objekat direktno u response.data
        console.log("sestra: ", sestra);
        setName(sestra.name);
        setEmail(sestra.email);
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

    // Provera da li su sva polja uneta
    if (!name || !email) {
      setError("Sva polja su obavezna!");
      return;
    }

    try {
      const response = await axiosClient.put(`/sestre/${id}`, {
        name,
        email,
        password,
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

        <Form onSubmit={handleSubmit} className="azurirajForma mt-3">
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

          {/* Polje za lozinku (nije obavezno) */}
          <Form.Group controlId="password" className="mb-3">
            <Form.Label className="text-light">Lozinka</Form.Label>
            <Form.Control
              type="password"
              placeholder="Unesite novu lozinku (ostavite prazno za zadržavanje trenutne)"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
            />
          </Form.Group>

          {/* Dugme za ažuriranje */}
          <Button className="w-100" variant="primary" type="submit">
            Ažuriraj sestru
          </Button>
        </Form>
      </Container>
    </Fragment>
  );
}
