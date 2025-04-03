import { Fragment, useEffect, useState } from "react";
import { Container, Form, Button } from "react-bootstrap";
import axiosClient from "./../../axios/axios-client";

export default function KreirajPregled() {
  const [datum, setDatum] = useState("");
  const [doktor, setDoktor] = useState("");
  const [sestra, setSestra] = useState("");
  const [terapija, setTerapija] = useState("");
  const [dijagnoza, setDijagnoza] = useState("");
  const [karton, setKarton] = useState("");
  const [errors, setErrors] = useState({});
  const [doktorList, setDoktorList] = useState([]);
  const [sestraList, setSestraList] = useState([]);
  const [terapijaList, setTerapijaList] = useState([]);
  const [dijagnozaList, setDijagnozaList] = useState([]);
  const [kartonList, setKartonList] = useState([]);
  const [responseMessage, setResponseMessage] = useState("");
  // Učitavanje podataka
  useEffect(() => {
    const fetchData = async () => {
      try {
        const [
          doktorResponse,
          sestraResponse,
          terapijaResponse,
          dijagnozaResponse,
          kartonResponse,
        ] = await Promise.all([
          axiosClient.get("doktori?include=user"),
          axiosClient.get("sestre?include=user"),
          axiosClient.get("terapije"),
          axiosClient.get("dijagnoze"),
          axiosClient.get("kartoni"),
        ]);
        setDoktorList(doktorResponse.data.data);
       
        setSestraList(sestraResponse.data.data);
        console.log(sestraResponse.data.data);
        setTerapijaList(terapijaResponse.data.data);
        setDijagnozaList(dijagnozaResponse.data.data);
        setKartonList(kartonResponse.data.data);
        const currentDate = new Date().toISOString().split("T")[0]; // Formatiranje u yyyy-mm-dd
        setDatum(currentDate);
      } catch (error) {
        console.log("Došlo je do greške pri učitavanju podataka", error);
      }
    };

    fetchData();
  }, []);

  // Validacija forme
  const validateForm = () => {
    const newErrors = {};
    if (!datum) newErrors.datum = "Datum je obavezan.";
    if (!doktor) newErrors.doktor = "Doktor je obavezan.";
    if (!sestra) newErrors.sestra = "Sestra je obavezna.";
    if (!terapija) newErrors.terapija = "Terapija je obavezna.";
    if (!dijagnoza) newErrors.dijagnoza = "Dijagnoza je obavezna.";
    if (!karton) newErrors.karton = "Karton je obavezan.";
    setErrors(newErrors);
    return Object.keys(newErrors).length === 0;
  };

  // Slanje podataka na server
  const handleSubmit = async (e) => {
    e.preventDefault();
    if (validateForm()) {
      try {
        const requestData = {
          datum: datum,
          doktor_id: parseInt(doktor),
          sestra_id: parseInt(sestra),
          terapija_id: parseInt(terapija),
          dijagnoza_id: parseInt(dijagnoza),
          karton_id: parseInt(karton),
        };
        console.log(requestData);
        const response = await axiosClient.post("pregledi", requestData);
        console.log(response);
        setResponseMessage("Pregled je uspešno kreiran!");

        setDatum("");
        setDoktor("");
        setSestra("");
        setTerapija("");
        setDijagnoza("");
        setKarton("");
      } catch (error) {
        if (error.response) {
          setResponseMessage(
            error.response.data.message || "Došlo je do greške."
          );
        } else {
          setResponseMessage("Došlo je do greške prilikom slanja zahteva.");
        }
      }
    }
  };

  return (
    <Fragment>
      <Container fluid={true} className="mainBanner pt-5">
        <Form className="kreirajPregledForma" onSubmit={handleSubmit}>
          <h2 className=" text-primary">Kreiraj pregled</h2>

          <Form.Group controlId="datum">
            <Form.Label className="text-light">Datum</Form.Label>
            <Form.Control type="date" value={datum} readOnly />
            <Form.Control.Feedback type="invalid">
              {errors.datum}
            </Form.Control.Feedback>
          </Form.Group>

          <Form.Group controlId="doktor">
            <Form.Label className="text-light">Doktor</Form.Label>
            <Form.Control
              as="select"
              value={doktor}
              onChange={(e) => setDoktor(e.target.value)}
              isInvalid={!!errors.doktor}
            >
              <option value="">Izaberite doktora</option>{" "}
              {/* Ova opcija je prazna i predstavlja početnu vrednost */}
              {doktorList.length > 0 ? (
                doktorList.map((value) => (
                  <option key={value.id} value={value.id}>
                    {value.user.name}
                  </option>
                ))
              ) : (
                <option>Nema doktora</option>
              )}
            </Form.Control>
            <Form.Control.Feedback type="invalid">
              {errors.doktor}
            </Form.Control.Feedback>
          </Form.Group>

          <Form.Group controlId="sestra">
            <Form.Label className="text-light">Sestra</Form.Label>
            <Form.Control
              as="select"
              value={sestra}
              onChange={(e) => setSestra(e.target.value)}
              isInvalid={!!errors.sestra}
            >
              <option value="">Izaberite sestru</option>{" "}
              {/* Ova opcija je prazna i predstavlja početnu vrednost */}
              {sestraList.length > 0 ? (
                sestraList.map((value) => (
                  <option key={value.id} value={value.id}>
                    {value.user.name}
                  </option>
                ))
              ) : (
                <option>Nema sestara</option>
              )}
            </Form.Control>
            <Form.Control.Feedback type="invalid">
              {errors.sestra}
            </Form.Control.Feedback>
          </Form.Group>

          <Form.Group controlId="terapija">
            <Form.Label className="text-light">Terapija</Form.Label>
            <Form.Control
              as="select"
              value={terapija}
              onChange={(e) => setTerapija(e.target.value)}
              isInvalid={!!errors.terapija}
            >
              <option value="">Izaberite terapiju</option>{" "}
              {/* Ova opcija je prazna i predstavlja početnu vrednost */}
              {terapijaList.length > 0 ? (
                terapijaList.map((value) => (
                  <option key={value.id} value={value.id}>
                    {value.naziv}
                  </option>
                ))
              ) : (
                <option>Nema terapija</option>
              )}
            </Form.Control>
            <Form.Control.Feedback type="invalid">
              {errors.terapija}
            </Form.Control.Feedback>
          </Form.Group>

          <Form.Group controlId="dijagnoza">
            <Form.Label className="text-light">Dijagnoza</Form.Label>
            <Form.Control
              as="select"
              value={dijagnoza}
              onChange={(e) => setDijagnoza(e.target.value)}
              isInvalid={!!errors.dijagnoza}
            >
              <option value="">Izaberite dijagnozu</option>{" "}
              {/* Ova opcija je prazna i predstavlja početnu vrednost */}
              {dijagnozaList.length > 0 ? (
                dijagnozaList.map((value) => (
                  <option key={value.id} value={value.id}>
                    {value.naziv}
                  </option>
                ))
              ) : (
                <option>Nema dijagnoza</option>
              )}
            </Form.Control>
            <Form.Control.Feedback type="invalid">
              {errors.dijagnoza}
            </Form.Control.Feedback>
          </Form.Group>

          <Form.Group controlId="karton">
            <Form.Label className="text-light">Karton</Form.Label>
            <Form.Control
              as="select"
              value={karton}
              onChange={(e) => setKarton(e.target.value)}
              isInvalid={!!errors.karton}
            >
              <option value="">Izaberite karton</option>{" "}
              {/* Ova opcija je prazna i predstavlja početnu vrednost */}
              {kartonList.length > 0 ? (
                kartonList.map((value) => (
                  <option key={value.id} value={value.id}>
                    {value.brojKnjizice}
                  </option>
                ))
              ) : (
                <option>Nema kartona</option>
              )}
            </Form.Control>
            <Form.Control.Feedback type="invalid">
              {errors.karton}
            </Form.Control.Feedback>
          </Form.Group>

          <Button
            variant="secondary"
            type="submit"
            className="bg-primary mt-3 w-100"
          >
            Kreiraj pregled
          </Button>
        </Form>

        {/* Prikazivanje poruke o uspehu ili grešci */}
        {responseMessage && (
          <div
            className={`alert ${
              responseMessage.includes("uspešno")
                ? "alert-success"
                : "alert-danger"
            }`}
            role="alert"
          >
            {responseMessage}
          </div>
        )}
      </Container>
    </Fragment>
  );
}
