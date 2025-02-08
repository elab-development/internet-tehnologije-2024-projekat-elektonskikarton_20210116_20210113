import { Fragment } from "react"
import NavBar from "../components/common/NavBar"
import Footer from "../components/common/Footer"
import DodajDoktora from "../components/doktori/DodajDoktoraBanner"


export default function KartonPage(){

    return(

        <Fragment>
            <NavBar></NavBar>
            <DodajDoktora></DodajDoktora>
            <Footer></Footer>
        </Fragment>
    )
}