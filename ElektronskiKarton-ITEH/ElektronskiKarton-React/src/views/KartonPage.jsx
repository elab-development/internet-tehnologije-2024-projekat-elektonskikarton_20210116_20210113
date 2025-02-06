import { Fragment } from "react"
import NavBar from "../components/common/NavBar"
import Karton from "../components/Karton/Karton"
import Footer from "../components/common/Footer"


export default function KartonPage(){

    return(

        <Fragment>
            <NavBar></NavBar>
            <Karton></Karton>
            <Footer></Footer>
        </Fragment>
    )
}