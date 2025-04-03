import { Fragment, useState, useEffect } from "react";
import { Container, Button, Table } from "react-bootstrap";
import axiosClient from "./../../axios/axios-client";

export default function SestreBanner() {
  const [sestre, setSestre] = useState([]);

  // Učitavanje liste sestara
  useEffect(() => {
    fetchSestre();
  }, []);

  const fetchSestre = async () => {
    try {
      const response = await axiosClient.get("sestre?include=user");
      setSestre(response.data.data);
    } catch (error) {
      console.error("Došlo je do greške prilikom učitavanja sestara.", error);
    }
  };

  const handleDelete = async (sestraId) => {
    if (window.confirm("Da li ste sigurni da želite da obrišete ovu sestru?")) {
      try {
        await axiosClient.delete(`sestre/${sestraId}`);
        setSestre(sestre.filter((sestra) => sestra.id !== sestraId));
      } catch (error) {
        console.error("Došlo je do greške prilikom brisanja sestre.", error);
      }
    }
  };

  return (
    <Fragment>
      <Container fluid={true} className="mainBanner  pt-5">
        <h2>Lista medicinskih sestara</h2>

        <div className="d-flex align-items-center mb-3">
          <Button variant="success" href="/dodaj-sestru">
            Dodaj sestru
          </Button>
        </div>

        {/* Tabela sestara */}
        <Table striped bordered hover>
          <thead>
            <tr>
              <th>#</th>
              <th>ID Korisnika</th>
              <th>Ime i prezime</th>
              <th>Akcije</th>
            </tr>
          </thead>
          <tbody>
            {sestre.length > 0 ? (
              sestre.map((sestra, index) => (
                <tr key={sestra.id}>
                  <td>{index + 1}</td>
                  <td>{sestra.user.name}</td>
                  <td>{sestra.user_id}</td>
                  <td>
                    <Button
                      variant="danger"
                      onClick={() => handleDelete(sestra.id)}
                    >
                      Obriši
                    </Button>
                  </td>
                </tr>
              ))
            ) : (
              <tr>
                <td colSpan="3" className="text-center">
                  Nema dostupnih sestara.
                </td>
              </tr>
            )}
          </tbody>
        </Table>
      </Container>
    </Fragment>
  );
}
