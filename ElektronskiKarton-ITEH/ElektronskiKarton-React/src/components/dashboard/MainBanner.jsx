/* eslint-disable no-unused-vars */
import { Fragment, useEffect, useState } from "react";
import { useStateContext } from "../../context/ContextProvider";
import { Container } from "react-bootstrap";
import axiosClient from "../../axios/axios-client";

export default function MainBanner() {
  const { user } = useStateContext();
  const [podaci, setPodaci] = useState(null); 
  const fetchDataForRole = async (user) => {
    try {
      let response;
      switch (user.role) {
        case "pacijent":
          response = await axiosClient.get(`pacijent/${user.id}`);
          break;
        case "sestra":
          response = await axiosClient.get(`sestra/${user.id}`);
          break;
        case "doktor":
          response = await axiosClient.get(`doktor/${user.id}`);
          break;
        case "admin":
          response = await axiosClient.get(`admin/${user.id}`);
          break;
        default:
          console.log("Nepoznata uloga.");
          return;
      }

      if (response && response.data) {
        setPodaci(response.data.data); 
      }
    } catch (error) {
      console.error("Greška pri dobijanju podataka:", error);
    }
  };

  useEffect(() => {
    
    if (user && user.role && user.id) {
      fetchDataForRole(user);
    }
  }, [user]); 

  return (
    <Fragment>
      <Container fluid={true} className="mainBanner">
        {}
        <div className="title nameContainer"  >
          <p>Dorbodošli {user.name}</p>
          <p>Uloga: {user.role}</p>
        </div>

      </Container>
    </Fragment>
  );
}
