import { Fragment, useState, useEffect } from "react";
import { Container, Form } from "react-bootstrap";
import axiosClient from "../../axios/axios-client";

export default function UstanoveBanner() {
  const [pacijenti, setPacijenti] = useState([]);
  const [searchQuery, setSearchQuery] = useState(""); // Stanje za pretragu
  const podaci = ["jmbg", "ulicaBroj", "telefon"]; // Ključevi koji će biti prikazani

  useEffect(() => {
    fetchPacijenti(searchQuery); // Pokretanje pretrage pri svakom unosu u pretragu
  }, [searchQuery]);

  const fetchPacijenti = async (query) => {
    try {
      const endpoint = query ? `pacijenti?jmbg=${query}` : "pacijenti";
      const response = await axiosClient.get(endpoint);
      setPacijenti(response.data.data);
    } catch (error) {
      console.log("Došlo je do greške", error);
    }
  };

  return (
    <Fragment>
      <Container fluid className="mainBanner pt-5">
        {/* Input za pretragu pacijenata */}
        <Form.Group className="mb-3" controlId="searchPacijent">
          <Form.Label>Pretraga pacijenata po JMBG-u</Form.Label>
          <Form.Control
            type="text"
            placeholder="Unesite JMBG"
            value={searchQuery}
            onChange={(e) => setSearchQuery(e.target.value)}
          />
        </Form.Group>

        <div>
          {pacijenti && pacijenti.length > 0 ? (
            pacijenti.map((value, index) => (
              <div className="custom-card" key={`pacijent-${index}`}>
                {Object.entries(value)
                  .filter(([key]) => podaci.includes(key)) // Filtriraj samo potrebne podatke
                  .map(([key, val]) => (
                    <div key={`${key}-${val}`}>
                      <h1 className="title">{formatKeyLabel(key)}</h1>
                      <p className="text">{val}</p>
                    </div>
                  ))}
              </div>
            ))
          ) : (
            <p>Učitavanje...</p>
          )}
        </div>
      </Container>
    </Fragment>
  );
}

function formatKeyLabel(key) {
  const labels = {
    naziv: "Naziv",
    ulicaBroj: "Ulica i broj",
    jmbg: "JMBG",
    telefon: "Telefon"
  };
  return labels[key] || key.replace(/([A-Z])/g, " $1").charAt(0).toUpperCase() + key.slice(1);
}
