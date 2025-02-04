import { Fragment, useEffect, useState } from "react";
import { useStateContext } from "../../context/ContextProvider";
import { Container } from 'react-bootstrap';
import axiosClient from "../../axios/axios-client";

export default function MainBanner() {
    const { user } = useStateContext();
    const [podaci, setPodaci] = useState(null); // State za bracniStatus

    const fetchDataForRole = async (user) => {
        try {
            let response;
            switch(user.role) {
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
                setPodaci(response.data.data); // Postavljanje podataka u state
                console.log(response.data.data)
            }
        } catch (error) {
            console.error("Greška pri dobijanju podataka:", error);
        }
    };

    useEffect(() => {
        // Provera da li postoji user pre poziva fetch funkcije
        if (user && user.role && user.id) {
            fetchDataForRole(user);
        }
    }, [user]); // Poziva se kad god se `user` menja

    return (
        <Fragment>
            <Container fluid={true} className="mainBanner">
                {/* Provera da li je bracniStatus dostupan pre prikaza */}
                Hello {user.role} {user.name}
            </Container>
        </Fragment>
    );
}
