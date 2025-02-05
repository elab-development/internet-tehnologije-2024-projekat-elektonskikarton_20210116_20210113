import { Container, Button, Form } from "react-bootstrap";
import { Fragment, useState, useEffect } from "react";
import { useParams } from "react-router-dom";
import axiosClient from "../../axios/axios-client";

export default function MojiPodaciBanner() {
  const { id } = useParams();
  const [pacijent, setPacijent] = useState({});
  const [errors, setErrors] = useState({});

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

  const validateData = () => {
    let newErrors = {};
    if (!pacijent.imePrezimeNZZ || pacijent.imePrezimeNZZ.length > 100) {
      newErrors.imePrezimeNZZ = "Ime i prezime ne sme biti prazno i mora imati manje od 100 karaktera.";
    }
    if (!pacijent.ulicaBroj) {
      newErrors.ulicaBroj = "Polje Ulica i broj je obavezno.";
    }
    if (!pacijent.telefon) {
      newErrors.telefon = "Polje Telefon je obavezno.";
    }
    if (!["u braku", "nije u braku"].includes(pacijent.bracniStatus)) {
      newErrors.bracniStatus = "Bračni status mora biti 'u braku' ili 'nije u braku'.";
    }
    if (!pacijent.mesto_postanskiBroj || isNaN(pacijent.mesto_postanskiBroj)) {
      newErrors.mesto_postanskiBroj = "Polje Poštanski broj mora biti brojčana vrednost.";
    }
    setErrors(newErrors);
    return Object.keys(newErrors).length === 0;
  };

  const handleSubmit = async () => {
    const podaciZaSlanje = {
      "imePrezimeNZZ": pacijent.imePrezimeNZZ,
      "ulicaBroj": pacijent.ulicaBroj,
      "telefon": pacijent.telefon,
      "bracniStatus": pacijent.bracniStatus.toLowerCase(), // Osiguraj da bude tačno "u braku" ili "nije u braku"
      "mesto_postanskiBroj": Number(pacijent.mesto_postanskiBroj) || 0, // Osiguraj da bude broj
    };
    console.log(podaciZaSlanje);
    if (!validateData()) return;
    try {
      await axiosClient.put(`pacijenti/${pacijent.jmbg}`, pacijent);
      alert("Podaci su uspešno izmenjeni!");
    } catch (error) {
      console.error("Greška prilikom slanja podataka:", error);
      alert("Došlo je do greške prilikom čuvanja podataka.");
    }
  };

  return (
      <Fragment>
        <Container fluid className="mainBanner pt-5">
          <div className="d-flex flex-column p-4 pacijentPodaci">
            <h1 className="text-center mb-4 title">Lični podaci</h1>
            {pacijent && Object.keys(pacijent).length > 0 ? (
              Object.entries(pacijent)
                .slice(1)
                .map(([key, value], index) => (
                  <div className="mb-3" key={index}>
                    <Form.Group className="d-flex align-items-center gap-4">
                      <Form.Label className="title w-50">{formatKeyLabel(key)}</Form.Label>
                      <Form.Control
                        type="text"
                        value={value}
                        onChange={(e) => handleInputChange(key, e.target.value)}
                        readOnly={!["telefon", "ulicaBroj", "imePrezimeNZZ", "bracniStatus", "mesto_postanskiBroj"].includes(key)}
                        isInvalid={!!errors[key]}
                        className={["telefon", "ulicaBroj", "imePrezimeNZZ", "bracniStatus", "mesto_postanskiBroj"].includes(key) ? "editableInput text w-50" : "text w-50"}
                      />
                      <Form.Control.Feedback type="invalid">{errors[key]}</Form.Control.Feedback>
                    </Form.Group>
                  </div>
                ))
            ) : (
              <p>Učitavanje podataka...</p>
            )}
            <Button className="mt-3 align-self-center title " variant="primary" onClick={handleSubmit}         style={{ borderRadius: "30px" }}
            >
              Sačuvaj izmene
            </Button>
          </div>
        </Container>
      </Fragment>
  );
}

// Helper funkcija za formatiranje ključnih reči
function formatKeyLabel(key) {
  const labels = {
    imePrezimeNZZ: "Ime i Prezime NZZ",
    ulicaBroj: "Ulica i Broj",
    telefon: "Telefon",
    bracniStatus: "Bračni status",
    mesto_postanskiBroj: "Poštanski broj"
  };
  return labels[key] || key.replace(/([A-Z])/g, " $1").charAt(0).toUpperCase() + key.slice(1);
}
