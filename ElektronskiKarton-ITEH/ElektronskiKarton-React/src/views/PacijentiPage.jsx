import { Fragment } from "react";
import NavBar from "../components/common/NavBar";
import Footer from "../components/common/Footer";
import PacijentiBanner from "../components/pacijenti/PacijentiBanner";

export default function PacijentiPage(){
    return(
        <Fragment>
            <NavBar></NavBar>
            <PacijentiBanner></PacijentiBanner>
            <Footer></Footer>
        </Fragment>
    )
}