import { Container, Button, Form } from "react-bootstrap";
import { Fragment, useState, useEffect } from "react";
import { useParams } from "react-router-dom";
import axiosClient from "../../axios/axios-client";
import Breadcrumb from 'react-bootstrap/Breadcrumb';


export default function MojiPodaciBanner() {
  const { id } = useParams();
  const [pacijent, setPacijent] = useState({});
  const [initialPacijent, setInitialPacijent] = useState({});
  const [errors, setErrors] = useState({});
  const [mesta, setMesta] = useState([]); 
  const [loading, setLoading] = useState(true); 
  const [isEditing, setIsEditing] = useState(false);

  useEffect(() => {
   
    const fetchData = async () => {
      try {
        const response = await axiosClient.get(`pacijent/${id}`);
        setPacijent(response.data.data);
        setInitialPacijent(response.data.data);
      } catch (error) {
        console.log("Došlo je do greške", error);
      }
    };

    const fetchMesta = async () => {
      try {
        const response = await axiosClient.get('mesta'); 
        setMesta(response.data.data);
        setLoading(false);
      } catch (error) {
        console.log("Greška pri učitavanju mesta", error);
        setLoading(false);
      }
    };

    fetchData();
    fetchMesta();
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
      "bracniStatus": pacijent.bracniStatus.toLowerCase(), 
      "mesto_postanskiBroj": Number(pacijent.mesto_postanskiBroj) || 0,
    };
    if (!validateData()) return;
    try {
      await axiosClient.put(`pacijenti/${pacijent.jmbg}`, podaciZaSlanje); 
      alert("Podaci su uspešno izmenjeni!");
      setIsEditing(false); 
      setInitialPacijent(pacijent); 
    } catch (error) {
      console.error("Greška prilikom slanja podataka:", error);
      alert("Došlo je do greške prilikom čuvanja podataka.");
    }
  };

  const handleCancel = () => {
    setPacijent(initialPacijent); 
    setIsEditing(false); 
  };

  return (
    <Fragment>
      <Container fluid className="mainBanner pt-5">
        <Breadcrumb className="breadcrumb">
                <Breadcrumb.Item href="dashboard">Početna</Breadcrumb.Item>
                <Breadcrumb.Item active>Moji podaci</Breadcrumb.Item>
        </Breadcrumb>
        <div className="d-flex flex-column p-4 pacijentPodaci">
          <h1 className="text-center mb-4 title">Lični podaci</h1>
          {pacijent && Object.keys(pacijent).length > 0 ? (
            Object.entries(pacijent)
              .slice(1)
              .map(([key, value], index) => (
                <div className="mb-3" key={index}>
                  <Form.Group className="d-flex align-items-center gap-4">
                    <Form.Label className="title w-50">{formatKeyLabel(key)}</Form.Label>
                    {key === "bracniStatus" ? (
                      <Form.Control 
                        as="select"
                        value={value}
                        onChange={(e) => handleInputChange(key, e.target.value)}
                        isInvalid={!!errors[key]}
                        className=" text w-50"
                        disabled={!isEditing}
                        style={{ backgroundColor: !isEditing ? "transparent" : "white", border: !isEditing ? "none" : "1px solid #ced4da", color: !isEditing ? "white" : "black" }}

                      >
                        <option value="u braku">U braku</option>
                        <option value="nije u braku">Nije u braku</option>
                      </Form.Control>
                    ) : key === "pol" ? (
                      <Form.Control
                        as="select"
                        value={value}
                        disabled
                        onChange={(e) => handleInputChange(key, e.target.value)}
                        isInvalid={!!errors[key]}
                        className="nonEditableInput text w-50"
                        style={{ backgroundColor: !isEditing ? "transparent" : "white", border: !isEditing ? "none" : "1px solid #ced4da", color: !isEditing ? "white" : "black" }}

                      >
                        <option value="muski">Muški</option>
                        <option value="zenski">Ženski</option>
                      </Form.Control>
                    ) : key === "mesto_postanskiBroj" ? (
                      loading ? (
                        <p>Učitavanje mesta...</p>
                      ) : (
                        <Form.Control
                          as="select"
                          value={value}
                          onChange={(e) => handleInputChange(key, e.target.value)}
                          isInvalid={!!errors[key]}
                          className=" text w-50"
                          disabled={!isEditing}
                          style={{ backgroundColor: !isEditing ? "transparent" : "white", border: !isEditing ? "none" : "1px solid #ced4da", color: !isEditing ? "white" : "black" }}
                          >
                          {mesta.map((mesto, index) => (
                            <option key={index} value={mesto.postanskiBroj}>
                              {mesto.naziv}
                            </option>
                          ))}
                        </Form.Control>
                      )
                    ) : (
                      <Form.Control
                        type="text"
                        value={value}
                        onChange={(e) => handleInputChange(key, e.target.value)}
                        readOnly={!isEditing || !["telefon", "ulicaBroj", "imePrezimeNZZ"].includes(key)}
                        isInvalid={!!errors[key]}
                        className={`text w-50 ${!isEditing || !["telefon", "ulicaBroj", "imePrezimeNZZ"].includes(key) ? "nonEditableInput" : ""}`}
                        style={{ backgroundColor: !isEditing ? "transparent" : "white", border: !isEditing ? "none" : "1px solid #ced4da", color: !isEditing ? "white" : "black" }}
                      />
                    )}
                    <Form.Control.Feedback type="invalid">{errors[key]}</Form.Control.Feedback>
                  </Form.Group>
                </div>
              ))
          ) : (
            <p>Učitavanje podataka...</p>
          )}
          {isEditing ? (
            <div className="d-flex justify-content-center gap-3">
              <Button className="mt-3 title" variant="success" onClick={handleSubmit} style={{ borderRadius: "30px" }}>
                Sačuvaj izmene
              </Button>
              <Button className="mt-3 title" variant="secondary" onClick={handleCancel} style={{ borderRadius: "30px" }}>
                Odustani
              </Button>
            </div>
          ) : (
            <Button className="mt-3 align-self-center title" variant="primary" onClick={() => setIsEditing(true)} style={{ borderRadius: "30px" }}>
              Omogući izmenu
            </Button>
          )}
        </div>
      </Container>
    </Fragment>
  );
}

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

