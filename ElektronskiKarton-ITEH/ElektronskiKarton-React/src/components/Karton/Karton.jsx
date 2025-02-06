import { Fragment, useState, useEffect } from "react";
import { Container } from "react-bootstrap";
import { useParams } from "react-router-dom";
import axiosClient from "./../../axios/axios-client";

export default function Karton() {
  const { id } = useParams();
  const [karton, setKarton] = useState({});
  //const [errors, setErrors] = useState({});

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axiosClient.get(`karton/${id}`);
        console.log(response.data.data);

        setKarton(response.data.data);
      } catch (error) {
        console.log("Došlo je do greške", error);
      }
    };
    fetchData();
  }, [id]);

  return (
    <Fragment>
      <Container fluid={true} className="mainBanner">
        {/* Provera da li je bracniStatus dostupan pre prikaza */}
        <div className="title nameContainer">
        {karton && Object.keys(karton).length > 0 ? (
              Object.entries(karton)
                .map(([key, value], index) => (
                  <div className="mb-3" key={index}>
                    <h1>{key}</h1>
                    <p>{value}</p>
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
