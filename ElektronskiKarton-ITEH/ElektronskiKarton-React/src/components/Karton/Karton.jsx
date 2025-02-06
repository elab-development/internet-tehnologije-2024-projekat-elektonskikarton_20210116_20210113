import { Fragment, useState, useEffect } from "react";
import { Container } from "react-bootstrap";
import { useParams } from "react-router-dom";
import axiosClient from "./../../axios/axios-client";

export default function Karton() {
  const { id } = useParams();
  const [karton, setKarton] = useState({});
  const [pregledi, setPregledi] = useState([]);
  const [selectedPregled, setSelectedPregled] = useState(null);

  const prikaziPreglede = async () => {
    try {
      const response = await axiosClient.get(`kartoni/${karton.id}?include=pregleds`);
      setPregledi(response.data.data.pregledi);
    } catch (err) {
      console.log("Došlo je do greške u pregledima", err);
    }
  };

  const ucitajPodatkePregleda = async (redniBroj) => {
    try {
  
      const response = await axiosClient.get(`pregledi/${karton.id}/${redniBroj}?include=doktor,terapija,dijagnoza`);
      console.log(response.data.data);
      setSelectedPregled({
        doktor: response.data.data.doktor,
        dijagnoza: response.data.data.dijagnoza,
        terapija: response.data.data.terapija,
      });
    } catch (err) {
      console.log("Greška u pregledu", err);
    }
  };

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axiosClient.get(`karton/${id}`);
        setKarton(response.data.data);
      } catch (error) {
        console.log("Došlo je do greške", error);
      }
    };
    fetchData();
  }, [id]);

  return (
    <Fragment>
      <Container fluid={true} className="mainBanner pt-5">
        <div className="title nameContainer">
          {karton && Object.keys(karton).length > 0 ? (
            <>
              {Object.entries(karton).map(([key, value], index) => (
                <div className="mb-3" key={index}>
                  <h1>{formatKeyLabel(key)}</h1>
                  <p>{value}</p>
                </div>
              ))}
              {/* Dugmadi se prikazuju samo kada je karton učitan */}
              <div>
                <button className="btn" onClick={prikaziPreglede}>Prikaži preglede</button>
              </div>

              {/* Prikaz pregleda */}
              {pregledi && pregledi.length > 0 && (
                <div>
                  {pregledi.map((pregled, index) => (
                    <div key={index} className="pregled">
                      {Object.entries(pregled).map(([key, value], idx) => (
                        <div key={idx}>
                          <h1>{formatKeyLabel(key)}</h1>
                          <p>{value}</p>
                        </div>
                      ))}
                      {/* Dugme za učitavanje dodatnih podataka za pregled */}
                      <button className="btn" onClick={() => ucitajPodatkePregleda(pregled.redniBroj)}>
                        Prikazi detalje pregleda
                      </button>
                    </div>
                  ))}
                </div>
              )}

              {/* Prikaz dodatnih podataka o pregledu */}
              {selectedPregled && (
                <div>
                  <h2>Doktor</h2>
                  {Object.entries(selectedPregled.doktor).map(([key, value], index) => (
                    <div key={index}>
                      <h3>{formatKeyLabel(key)}</h3>
                      <p>{value}</p>
                    </div>
                  ))}
                  <h2>Dijagnoza</h2>
                  {Object.entries(selectedPregled.dijagnoza).map(([key, value], index) => (
                    <div key={index}>
                      <h3>{formatKeyLabel(key)}</h3>
                      <p>{value}</p>
                    </div>
                  ))}
                  <h2>Terapija</h2>
                  {Object.entries(selectedPregled.terapija).map(([key, value], index) => (
                    <div key={index}>
                      <h3>{formatKeyLabel(key)}</h3>
                      <p>{value}</p>
                    </div>
                  ))}
                </div>
              )}
            </>
          ) : (
            <p>Učitavanje podataka...</p>
          )}
        </div>
      </Container>
    </Fragment>
  );
}

function formatKeyLabel(key) {
  const labels = {
    brojKnjizice: "Broj knjižice",
    napomene: "Napomene",
    pacijent_jmbg: "JMBG pacijenta",
    redniBroj: "Redni broj"
  };
  return labels[key] || key.replace(/([A-Z])/g, " $1").charAt(0).toUpperCase() + key.slice(1);
}
