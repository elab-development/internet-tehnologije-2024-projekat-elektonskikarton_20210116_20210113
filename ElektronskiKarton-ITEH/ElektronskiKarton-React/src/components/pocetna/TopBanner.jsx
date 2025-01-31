import { Fragment } from "react";
import { Container, Row, Col} from "react-bootstrap";


export default function TopBanner(){

    return(
        <Fragment>
            <Container fluid className="topFixedBanner">
                <div className="topBannerOverlay">
                    <Row>
                        <Col lg={6} md={6} sm={12} className="topBannerText">
                            <h1 className="title">Efikasno upravljanje medicinskim kartonima</h1>
                            <p>Bezbedno čuvajte, pretražujte i upravljajte elektronskim medicinskim podacima pacijenata – sve na jednom mestu, uz brzi pristup i maksimalnu privatnost.</p>
                        </Col>
                        <Col lg={6} md={6} sm={12}></Col>
                    </Row>
                </div>
            </Container>
        </Fragment>
    )
}