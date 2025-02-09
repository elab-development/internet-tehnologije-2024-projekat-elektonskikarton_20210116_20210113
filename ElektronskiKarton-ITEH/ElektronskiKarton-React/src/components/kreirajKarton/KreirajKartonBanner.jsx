import { Fragment, useEffect, useState } from "react";
import { Container, Form, Button } from "react-bootstrap";
import axiosClient from "./../../axios/axios-client";

export default function KreirajKartonBanner() {
  const [brojKnjizice, setBrojKnjizice] = useState("");
  const [napomene, setNapomene] = useState("");
  const [ustanova, setUstanova] = useState("");
  const [pacijentJmbg, setPacijentJmbg] = useState("");
  const [errors, setErrors] = useState({});
  const [ustanove, setUstanove] = useState([]);
  const [responseMessage, setResponseMessage] = useState(""); // Dodano stanje za poruku

  // Učitavanje ustanova
  useEffect(() => {
    const fetchMesta = async () => {
      try {
        const response = await axiosClient.get("ustanove");
        setUstanove(response.data.data);
      } catch (error) {
        console.log("Došlo je do greške pri učitavanju mesta", error);
      }
    };

    fetchMesta();
  }, []);

  // Validacija forme
  const validateForm = () => {
    const newErrors = {};
    if (!brojKnjizice) newErrors.brojKnjizice = "Broj knjižice je obavezan.";
    if (!napomene) newErrors.napomene = "Napomene su obavezne.";
    if (!ustanova) newErrors.ustanova = "Ustanova je obavezna.";
    if (!pacijentJmbg || pacijentJmbg.length !== 13) {
      newErrors.pacijentJmbg = "JMBG mora imati 13 cifara.";
    }
    setErrors(newErrors);
    return Object.keys(newErrors).length === 0;
  };

  // Slanje podataka na server
  const handleSubmit = async (e) => {
    e.preventDefault();
    if (validateForm()) {
      try {
        const requestData = {
          "brojKnjizice": brojKnjizice,
          "napomene": napomene,
          "ustanova_id": parseInt(ustanova), // koristi id ustanove kao integer
          "pacijent_jmbg": pacijentJmbg,
        };

        const response = await axiosClient.post("kartoni", requestData);
        console.log(response);
        setResponseMessage("Karton je uspešno kreiran!");

        setBrojKnjizice("");
        setNapomene("");
        setUstanova("");
        setPacijentJmbg("");

      } catch (error) {
        if (error.response) {
          setResponseMessage(error.response.data.message || "Došlo je do greške.");
        } else {
          setResponseMessage("Došlo je do greške prilikom slanja zahteva.");
        }
      }
    }
  };

  return (
    <Fragment>
      <Container fluid={true} className="mainBanner pt-5">
        <h2 className="mt-5">Kreiraj karton</h2>
        <Form className="kreirajKartonForma" onSubmit={handleSubmit}>
          <Form.Group controlId="brojKnjizice">
            <Form.Label>Broj knjižice</Form.Label>
            <Form.Control
              type="text"
              value={brojKnjizice}
              onChange={(e) => setBrojKnjizice(e.target.value)}
              isInvalid={!!errors.brojKnjizice}
            />
            <Form.Control.Feedback type="invalid">
              {errors.brojKnjizice}
            </Form.Control.Feedback>
          </Form.Group>

          <Form.Group controlId="napomene">
            <Form.Label>Napomene</Form.Label>
            <Form.Control
              as="textarea"
              value={napomene}
              onChange={(e) => setNapomene(e.target.value)}
              isInvalid={!!errors.napomene}
            />
            <Form.Control.Feedback type="invalid">
              {errors.napomene}
            </Form.Control.Feedback>
          </Form.Group>

          <Form.Group controlId="ustanova">
            <Form.Label>Ustanova</Form.Label>
            <Form.Control
              as="select"
              value={ustanova}
              onChange={(e) => setUstanova(e.target.value)}
              isInvalid={!!errors.ustanova}
            >
              {ustanove && ustanove.length > 0 ? (
                ustanove.map((value) => (
                  <option key={value.id} value={value.id}>
                    {value.naziv}
                  </option>
                ))
              ) : (
                <option>Nema mesta</option>
              )}
            </Form.Control>
            <Form.Control.Feedback type="invalid">
              {errors.ustanova}
            </Form.Control.Feedback>
          </Form.Group>

          <Form.Group controlId="pacijentJmbg">
            <Form.Label>JMBG pacijenta</Form.Label>
            <Form.Control
              type="text"
              value={pacijentJmbg}
              onChange={(e) => setPacijentJmbg(e.target.value)}
              isInvalid={!!errors.pacijentJmbg}
            />
            <Form.Control.Feedback type="invalid">
              {errors.pacijentJmbg}
            </Form.Control.Feedback>
          </Form.Group>

          <Button className="bg-primary mt-3 w-100" variant="secondary" type="submit">
            Kreiraj karton
          </Button>
        </Form>

        {/* Prikazivanje poruke o uspehu ili grešci */}
        {responseMessage && (
          <div className={`alert ${responseMessage.includes('uspešno') ? 'alert-success' : 'alert-danger'}`} role="alert">
            {responseMessage}
          </div>
        )}
      </Container>
    </Fragment>
  );
}
