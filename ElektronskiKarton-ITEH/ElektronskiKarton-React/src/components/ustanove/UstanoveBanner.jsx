import { Fragment, useState, useEffect } from "react";
import { Container } from "react-bootstrap"
import axiosClient from "../../axios/axios-client";
import Card from 'react-bootstrap/Card';


export default function UstanoveBanner() {

    const [ustanove, setUstanove] = useState([]);

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axiosClient.get(`ustanove`);
                setUstanove(response.data.data);
            } catch (error) {
                console.log("Došlo je do greške", error);
            }
        };
        fetchData();
    });

    return (
        <Fragment>
            <Container fluid className="mainBanner pt-5">
                <div>
                    {ustanove && ustanove.length > 0 ? (
                        ustanove.map((value, index) => (
                            <div className="custom-card">
                                {Object.entries(value).map(([key, val], idx) => (
                                    <div key={idx}>

                                        
                                            <h1>{key}</h1>
                                            <p>{val}</p>
                                            </Card>
                                    </div>
                                ))}
                            </Card>
                        ))
                    ) : (
                        <p>Učitavanje...</p>
                    )}
                </div>
            </Container>
        </Fragment>
    )
}