import { Container, Button } from "react-bootstrap";
import { Fragment, useState, useEffect } from "react";
import { useParams } from "react-router-dom";
import axiosClient from "../../axios/axios-client";

export default function MojiPodaciBanner() {
  const { id } = useParams();
  const [pacijent, setPacijent] = useState({});

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axiosClient.get(`pacijent/${id}`);
        setPacijent(response.data.data);
      } catch (error) {
        console.log("Došlo je do greške", error);
      }
    };
    fetchData();
  }, [id]);

  const handleInputChange = (key, value) => {
    setPacijent((prev) => ({
      ...prev,
      [key]: value,
    }));
  };

  const handleSubmit = async () => {
    try {
      await axiosClient.put(`pacijenti/${pacijent.jmbg}`, pacijent); // Slanje izmenjenih podataka
      alert("Podaci su uspešno izmenjeni!");
    } catch (error) {
      console.error("Greška prilikom slanja podataka:", error);
      alert("Došlo je do greške prilikom čuvanja podataka.");
    }
  };

  return (
    <Fragment>
      <Container fluid className="mainBanner pt-5">
        <div className="d-flex flex-column p-4 rounded pacijentPodaci">
          <h1 className="text-center mb-4">Lični podaci</h1>
          {pacijent && Object.keys(pacijent).length > 0 ? (
            Object.entries(pacijent)
              .slice(1)
              .map(([key, value], index) => (
                <div className="d-flex justify-content-between align-items-center mb-3" key={index}>
                  <strong className="me-2">{formatKeyLabel(key)}:</strong>
                  <input
                    className="form-control w-75"
                    type="text"
                    value={value}
                    onChange={(e) => handleInputChange(key, e.target.value)}
                    readOnly={key !== "telefon" && key !== "ulicaBroj" && key !== "imePrezimeNZZ" && key !== "bracniStatus" && key !== "mesto_postanskiBroj"}
                  />
                </div>
              ))
          ) : (
            <p>Učitavanje podataka...</p>
          )}
          <Button className="mt-3 align-self-center" variant="primary" onClick={handleSubmit}>
            Sačuvaj izmene
          </Button>
        </div>
      </Container>
    </Fragment>
  );
}

// Helper funkcija za formatiranje ključnih reči
function formatKeyLabel(key) {
  switch (key) {
    case "imePrezimeNZZ":
      return "Ime i Prezime NZZ";
    case "ulicaBroj":
      return "Ulica i Broj";
    default:
      return key.replace(/([A-Z])/g, " $1").charAt(0).toUpperCase() + key.slice(1);
  }
}
