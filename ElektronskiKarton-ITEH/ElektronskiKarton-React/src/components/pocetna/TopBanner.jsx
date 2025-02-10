import { Fragment, useEffect } from "react";
import { Container, Row, Col } from "react-bootstrap";
import { init } from "ityped";

export default function TopBanner() {
  useEffect(() => {
    const myElement = document.querySelector("#myElement");
    init(myElement, {
      showCursor: false,
      strings: ["Efikasno upravljanje medicinskim kartonima"],
    });
  },[]);

  return (
    <Fragment>
      <Container fluid className="topFixedBanner">
        <div className="topBannerOverlay">
          <Row className="topBannerContainer">
            <Col lg={6} md={6} sm={12} className="topBannerText">
              <h1 className="title" id="myElement">
                
              </h1>
              <p className="text">
                Bezbedno čuvajte, pretražujte i upravljajte elektronskim
                medicinskim podacima pacijenata – sve na jednom mestu, uz brzi
                pristup i maksimalnu privatnost.
              </p>
            </Col>
            <Col lg={6} md={6} sm={12}></Col>
          </Row>
        </div>
      </Container>
    </Fragment>
  );
}
