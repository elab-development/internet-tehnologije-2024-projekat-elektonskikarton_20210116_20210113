import { Fragment } from "react";
import NavBar from "../components/common/NavBar";
import Footer from "../components/common/Footer";
import KreirajKartonBanner from "../components/kreirajKarton/KreirajKartonBanner";

export default function KreirajKartonPage(){
    return(
        <Fragment>
            <NavBar></NavBar>
            <KreirajKartonBanner></KreirajKartonBanner>
            <Footer></Footer>
        </Fragment>
    )
}