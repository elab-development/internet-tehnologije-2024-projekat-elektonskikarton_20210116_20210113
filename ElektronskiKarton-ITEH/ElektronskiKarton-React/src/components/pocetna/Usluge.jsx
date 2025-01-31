import { Fragment } from "react";
import { Col, Container, Row } from "react-bootstrap";
import service1 from "../../assets/images/services1.jpg";
import service2 from "../../assets/images/services2.jpg";
import service3 from "../../assets/images/services3.jpg";

export default function Usluge() {
  return (
    <Fragment>
      <Container>
        <Row>
          <Col lg={4} md={12} sm={12}>
            <div className="serviceCard text-center">
              <img src={service1}/>
              <h3 className="title">Uvid u e-kartone</h3>
              <p className="text">
                Omogućavamo lekarima, medicinskim sestrama i administrativnom
                osoblju brz i jednostavan pristup kompletnim zdravstvenim
                kartonima pacijenata. Bezbedno čuvanje i ažuriranje podataka
                omogućava precizno vođenje medicinske dokumentacije.
              </p>
            </div>
          </Col>
          <Col lg={4} md={12} sm={12}>
            <div className="serviceCard text-center">
              <img src={service2}/>
              <h3 className="title">Dokumentovanje pregleda</h3>
              <p className="text">
                Ubrzajte proces pregleda pacijenata uz digitalno vođenje
                evidencije. Lekari mogu unositi dijagnoze, terapije i napomene u
                realnom vremenu, dok medicinsko osoblje ima brzi pristup
                kompletnoj istoriji zdravstvenih podataka.
              </p>
            </div>
          </Col>
          <Col lg={4} md={12} sm={12}>
            <div className="serviceCard text-center">
              <img src={service3}/>
              <h3 className="title">Bezbedno čuvanje i pristup podacima</h3>
              <p className="text">
                Vaši podaci su prioritet. Uz najmodernije sigurnosne protokole i
                kontrolu pristupa, obezbeđujemo poverljivost, integritet i
                zaštitu informacija o pacijentima, lekarima i terapijama.
              </p>
            </div>
          </Col>
        </Row>
      </Container>
    </Fragment>
  );
}
