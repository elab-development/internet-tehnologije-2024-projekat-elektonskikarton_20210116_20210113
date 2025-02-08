import { Fragment, useState, useEffect } from "react";
import { Container, Form, Button, Table } from "react-bootstrap";
import axiosClient from "./../../axios/axios-client";

export default function DoktoriBanner() {
  const [doktori, setDoktori] = useState([]);
  const [filterSpecijalizacija, setFilterSpecijalizacija] = useState("");

  // Učitavanje liste doktora
  useEffect(() => {
    fetchDoktori();
  }, []);

  const fetchDoktori = async (specijalizacija = "") => {
    try {
      const response = await axiosClient.get(
        `doktori${specijalizacija ? `?specijalizacija=${specijalizacija}` : ""}`
      );
      setDoktori(response.data.data);
    } catch (error) {
      console.error("Došlo je do greške prilikom učitavanja doktora.", error);
    }
  };

  const handleFilterChange = (e) => {
    setFilterSpecijalizacija(e.target.value);
  };

  const handleFilterSubmit = () => {
    fetchDoktori(filterSpecijalizacija);
  };

  const obrisiFilter = () => {
    setFilterSpecijalizacija("");
    fetchDoktori();
  }

  const handleDelete = async (doktorId) => {
    if (window.confirm("Da li ste sigurni da želite da obrišete ovog doktora?")) {
      try {
        await axiosClient.delete(`doktori/${doktorId}`);
        setDoktori(doktori.filter((doktor) => doktor.id !== doktorId));
      } catch (error) {
        console.error("Došlo je do greške prilikom brisanja doktora.", error);
      }
    }
  };

  return (
    <Fragment>
      <Container fluid={true} className="mainBanner mt-5">
        <h2>Lista doktora</h2>

        {/* Filter i dugme za dodavanje */}
        <div className="d-flex align-items-center mb-3">
          <Form.Control
            type="text"
            placeholder="Pretraga po specijalizaciji"
            value={filterSpecijalizacija}
            onChange={handleFilterChange}
            className="me-2"
          />
          <Button variant="secondary" onClick={handleFilterSubmit}>
            Filtriraj
          </Button>
          <Button onClick={obrisiFilter}>Obriši filter</Button>
          <Button variant="success" className="ms-2" href="/dodaj-doktora">
            Dodaj doktora
          </Button>
        </div>

        {/* Tabela doktora */}
        <Table striped bordered hover>
          <thead>
            <tr>
              <th>#</th>
              <th>Specijalizacija</th>
              <th>Akcije</th>
            </tr>
          </thead>
          <tbody>
            {doktori.length > 0 ? (
              doktori.map((doktor, index) => (
                <tr key={doktor.id}>
                  <td>{index + 1}</td>
                  <td>{doktor.specijalizacija}</td>
                  <td>
                    <Button
                      variant="warning"
                      className="me-2"
                      href={`/azuriraj-doktora/${doktor.user_id}`}
                    >
                      Ažuriraj
                    </Button>
                    <Button
                      variant="danger"
                      onClick={() => handleDelete(doktor.id)}
                    >
                      Obriši
                    </Button>
                  </td>
                </tr>
              ))
            ) : (
              <tr>
                <td colSpan="4" className="text-center">
                  Nema dostupnih doktora.
                </td>
              </tr>
            )}
          </tbody>
        </Table>
      </Container>
    </Fragment>
  );
}
