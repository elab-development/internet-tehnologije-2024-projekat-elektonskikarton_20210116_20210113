import { Fragment } from "react"
import NavBar from "../components/common/NavBar"
import Footer from "../components/common/Footer"
import AzurirajDoktoraBanner from "../components/doktori/AzurirajDoktoraBanner"


export default function KartonPage(){

    return(

        <Fragment>
            <NavBar></NavBar>
            <AzurirajDoktoraBanner></AzurirajDoktoraBanner>
            <Footer></Footer>
        </Fragment>
    )
}