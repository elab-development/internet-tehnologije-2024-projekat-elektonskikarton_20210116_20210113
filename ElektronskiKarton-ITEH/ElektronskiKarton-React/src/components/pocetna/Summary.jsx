/* eslint-disable no-unused-vars */
import { Fragment, useEffect, useState } from "react";
import { Col, Container, Row } from "react-bootstrap";
import CountUp from "react-countup";
import ReactVisibilitySensor from "react-visibility-sensor";
import axiosClient from "../../axios/axios-client";
import {
  getDoctorCount,
  getPatientCount,
  getUstanoveCount,
} from "../../axios/api";

export default function Summary() {
  const [data, setData] = useState({
    doctorCount: 0,
    patientCount: 0,
    ustanoveCount: 0,
  });
  const [error, setError] = useState(false);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const [doctorRes, patientRes, ustanoveRes] = await Promise.all([
          getDoctorCount(),
          getPatientCount(),
          getUstanoveCount(),
        ]);

        setData({
          doctorCount: doctorRes.data.doktor_count,
          patientCount: patientRes.data.pacijent_count,
          ustanoveCount: ustanoveRes.data.ustanove_count,
        });
      } catch (error) {
        console.error("Error fetching dashboard data:", error);
      }
    };

    fetchData();
  }, []);

  return (
    <Fragment>
      <Container fluid={true} className="summaryBanner">
        <div className="summaryBannerOverlay d-flex align-items-center">
          <Row className="d-flex w-100 justify-content-evenly" >
            <Col lg={4} md={4} sm={12} className="text-center">
              <h1 className="countNumber title">
                <CountUp start={0} end={data.ustanoveCount}>
                  {({ countUpRef, start }) => (
                    <ReactVisibilitySensor onChange={start} delayedCall>
                      <span ref={countUpRef} />
                    </ReactVisibilitySensor>
                  )}
                </CountUp>
              </h1>
              <h4 className="title">Ustanova u Srbiji</h4>
              <hr className="bg-white w-30"></hr>
            </Col>
            <Col lg={4} md={4} sm={12} className="text-center ">
              <h1 className="countNumber title">
                <CountUp start={0} end={data.patientCount}>
                  {({ countUpRef, start }) => (
                    <ReactVisibilitySensor onChange={start} delayedCall>
                      <span ref={countUpRef} />
                    </ReactVisibilitySensor>
                  )}
                </CountUp>
              </h1>
              <h4 className="title">Zadovoljnih korisnika</h4>
              <hr className="bg-white w-30"></hr>
            </Col>
            <Col lg={4} md={4} sm={12} className="text-center ">
              <h1 className="countNumber title">
                <CountUp start={0} end={data.doctorCount}>
                  {({ countUpRef, start }) => (
                    <ReactVisibilitySensor onChange={start} delayedCall>
                      <span ref={countUpRef} />
                    </ReactVisibilitySensor>
                  )}
                </CountUp>
              </h1>
              <h4 className="title">Sertifikovanih lekara</h4>
              <hr className="bg-white w-30"></hr>
            </Col>
          </Row>
        </div>
      </Container>
    </Fragment>
  );
}
