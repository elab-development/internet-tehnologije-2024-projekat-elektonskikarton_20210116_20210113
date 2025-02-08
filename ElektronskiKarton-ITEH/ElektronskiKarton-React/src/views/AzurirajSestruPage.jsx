import { Fragment } from "react"
import NavBar from "../components/common/NavBar"
import Footer from "../components/common/Footer"
import AzurirajSestruBanner from './../components/sestre/AzurirajSestreBanner';


export default function AzurirajSestruPage(){

    return(

        <Fragment>
            <NavBar></NavBar>
            <AzurirajSestruBanner></AzurirajSestruBanner>
            <Footer></Footer>
        </Fragment>
    )
}