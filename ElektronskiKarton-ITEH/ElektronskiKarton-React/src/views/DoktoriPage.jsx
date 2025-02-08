import { Fragment } from "react"
import NavBar from "../components/common/NavBar"
import Footer from "../components/common/Footer"
import DoktoriBanner from "../components/doktori/DoktoriBanner"


export default function KartonPage(){

    return(

        <Fragment>
            <NavBar></NavBar>
            <DoktoriBanner></DoktoriBanner>
            <Footer></Footer>
        </Fragment>
    )
}