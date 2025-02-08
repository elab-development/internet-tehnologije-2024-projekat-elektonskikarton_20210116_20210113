import { Fragment, useState, useEffect } from "react";
import { Container, Form } from "react-bootstrap";
import axiosClient from "../../axios/axios-client";

export default function UstanoveBanner() {
  const [ustanove, setUstanove] = useState([]);
  const [searchNaziv, setSearchNaziv] = useState(""); // Stanje za pretragu po nazivu
  const [searchMesto, setSearchMesto] = useState(""); // Stanje za pretragu po mestu
  const [mesta, setMesta] = useState([]); // Stanje za lista mesta

  // Učitavanje lista mesta sa API-ja
  useEffect(() => {
    const fetchMesta = async () => {
      try {
        const response = await axiosClient.get("mesta"); // PUT YOUR API URL
        setMesta(response.data); // Pretpostavljam da odgovor bude lista mesta
      } catch (error) {
        console.log("Došlo je do greške pri učitavanju mesta", error);
      }
    };

    fetchMesta();
  }, []);

  // Učitavanje ustanova sa API-ja sa parametrima
  useEffect(() => {
    const fetchData = async () => {
      try {
        // Kreiranje URL sa query parametrima
        let url = "ustanove";
        const searchParams = new URLSearchParams();

        if (searchNaziv) searchParams.append("naziv", searchNaziv);
        if (searchMesto) searchParams.append("mesto", searchMesto);

        if (searchParams.toString()) {
          url = `${url}?${searchParams.toString()}`;
        }

        const response = await axiosClient.get(url); // Poziv API-ja sa parametrima u URL-u
        setUstanove(response.data.data);
      } catch (error) {
        console.log("Došlo je do greške pri učitavanju ustanova", error);
      }
    };

    fetchData();
  }, [searchNaziv, searchMesto]); // Zavisi od oba parametra

  return (
    <Fragment>
      <Container fluid className="mainBanner pt-5">
        <Form.Group className="mb-3" controlId="searchNaziv">
          <Form.Label>Pretraga po Nazivu</Form.Label>
          <Form.Control
            type="text"
            placeholder="Unesite naziv"
            value={searchNaziv}
            onChange={(e) => setSearchNaziv(e.target.value)}
          />
        </Form.Group>

        <Form.Group className="mb-3" controlId="searchMesto">
          <Form.Label>Pretraga po Mestu</Form.Label>
          <Form.Control
            as="select"
            value={searchMesto}
            onChange={(e) => setSearchMesto(e.target.value)} 
          >
            <option value="">Izaberite mesto</option>
            {mesta && mesta.length > 0 ? (
              mesta.map((mesto) =>
                Object.entries(mesto).map(([key, val]) => (
                  <option key={key} value={val}>
                    {val}
                  </option>
                ))
              )
            ) : (
              <option value="">Nema mesta</option>
            )}
          </Form.Control>
        </Form.Group>

        <div>
          {ustanove && ustanove.length > 0 ? (
            ustanove.map((value, index) => (
              <div className="custom-card" key={`ustanova-${index}`}>
                {Object.entries(value).map(([key, val]) => (
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
    mesto: "Mesto",
  };
  return (
    labels[key] ||
    key
      .replace(/([A-Z])/g, " $1")
      .charAt(0)
      .toUpperCase() + key.slice(1)
  );
}
