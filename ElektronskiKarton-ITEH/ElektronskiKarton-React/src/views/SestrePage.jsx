import { Fragment } from "react"
import NavBar from "../components/common/NavBar"
import Footer from "../components/common/Footer"
import SestreBanner from "../components/sestre/SestreBannner"


export default function SestrePage(){

    return(

        <Fragment>
            <NavBar></NavBar>
            <SestreBanner></SestreBanner>
            <Footer></Footer>
        </Fragment>
    )
}