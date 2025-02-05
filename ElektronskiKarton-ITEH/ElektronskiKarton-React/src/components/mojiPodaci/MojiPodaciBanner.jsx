import { Container } from "react-bootstrap";
import { Fragment, useState, useEffect } from "react";
import { useParams } from "react-router-dom";
import axiosClient from "../../axios/axios-client";

export default function MojiPodaciBanner() {
  const { id } = useParams();
  const [pacijent, setPacijent] = useState(null);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axiosClient.get(`pacijent/${id}`);
        setPacijent(response.data.data); // direktno čuvamo objekat
      } catch (error) {
        console.log("Doslo je do greske", error);
      }
    };
    fetchData();
  }, [id]);

  return (
    <Fragment>
      <Container fluid={true} className="mainBanner">
        <div className="d-flex flex-column title border pacijentPodaci">
            <h1 className="text-center">Lični podaci</h1>
          {pacijent ? (
            // Iteriraj kroz ključ-vrednost parove objekta
            Object.entries(pacijent).slice(1).map(([key, value], index) => (
              <div className="m-1" key={index}>
                <strong>{key}:</strong> 
                <input className="pacijentInput ms-2" type="text" value={value}/>
              </div>
            ))
          ) : (
            <p>Učitavanje podataka...</p>
          )}
        </div>
      </Container>
    </Fragment>
  );
}
