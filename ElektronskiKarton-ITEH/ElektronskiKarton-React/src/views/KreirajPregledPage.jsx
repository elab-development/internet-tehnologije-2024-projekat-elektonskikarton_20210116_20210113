import { Fragment } from "react";
import NavBar from "../components/common/NavBar";
import Footer from "../components/common/Footer";
import KreirajPregledBanner from "../components/kreirajPregled/KreirajPregledBanner";

export default function KreirajKartonPage(){
    return(
        <Fragment>
            <NavBar></NavBar>
            <KreirajPregledBanner></KreirajPregledBanner>
            <Footer></Footer>
        </Fragment>
    )
}