import { Fragment } from "react";
import { Container, Row, Col } from "react-bootstrap";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import { faFacebook } from "@fortawesome/free-brands-svg-icons";
import { faYoutube } from "@fortawesome/free-brands-svg-icons";
import { faTwitter } from "@fortawesome/free-brands-svg-icons";
import {faPhone } from "@fortawesome/free-solid-svg-icons";
import {faMapPin } from "@fortawesome/free-solid-svg-icons";

export default function Footer() {
  return (
    <Fragment>
      <Container fluid={true} className="footerSection pb-5">
        <Row className="pt-5">
          <Col lg={4} md={4} sm={12} >
            <h2 className="footerName text-center pb-3">Zaprati nas</h2>
            <div className="m-2 text-center">
              <a className="p-2 text-light iconTransition" href="">
                <FontAwesomeIcon className="social" icon={faFacebook} size="2x"></FontAwesomeIcon>
              </a>
              <a className="p-2 text-light iconTransition" href="">
                <FontAwesomeIcon className="social" icon={faYoutube} size="2x"></FontAwesomeIcon>
              </a>
              <a className="p-2 text-light iconTransition" href="">
                <FontAwesomeIcon className="social" icon={faTwitter} size="2x"></FontAwesomeIcon>
              </a>
            </div>
          </Col>
          <Col lg={4} md={4} sm={12}>
            <h2 className="footerName text-center">Adresa</h2>
            <p className="text-center">
            <FontAwesomeIcon icon={faMapPin} className="pe-2"/>
              Jove Ilića 134<br></br> Voždovac, Beograd
            </p>
          </Col>
          <Col lg={4} md={4} sm={12}>
            <h2 className="footerName text-center">Kontakt</h2>
            <p className="text-center">
            <FontAwesomeIcon icon={faPhone} className="pe-2"/>
              +381 011 123 456<br></br>
              <FontAwesomeIcon icon={faPhone} className="pe-2" />
              +381 011 987 654
            </p>
          </Col>
        </Row>
      </Container>
      <Container fluid={true} className="copyrightSection">
        <p className="m-0">Copyright © 2025 Internet sistemi i tehnologije, FON</p>
      </Container>
    </Fragment>
  );
}
