import { Fragment } from "react"
import NavBar from "../components/common/NavBar"
import Footer from "../components/common/Footer"
import DodajSestruBanner from "../components/sestre/DodajSestruBanner"


export default function DodajSestruPage(){

    return(

        <Fragment>
            <NavBar></NavBar>
            <DodajSestruBanner></DodajSestruBanner>
            <Footer></Footer>
        </Fragment>
    )
}