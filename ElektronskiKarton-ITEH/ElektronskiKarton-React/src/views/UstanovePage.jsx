import { Fragment } from "react";
import NavBar from "../components/common/NavBar";
import Footer from "../components/common/Footer";
import UstanoveBanner from './../components/ustanove/UstanoveBanner';


export default function UstanovePage(){
    return(
        <Fragment>
            <NavBar></NavBar>
            <UstanoveBanner></UstanoveBanner>
            <Footer></Footer>
        </Fragment>
    )
}