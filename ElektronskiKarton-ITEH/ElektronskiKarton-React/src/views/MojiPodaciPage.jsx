import { Fragment } from "react";
import NavBar from "../components/common/NavBar";
import Footer from "../components/common/Footer";
import MojiPodaciBanner from './../components/mojiPodaci/MojiPodaciBanner';


export default function MojiPodaci(){
    return(
        <Fragment>
            <NavBar></NavBar>
            <MojiPodaciBanner></MojiPodaciBanner>
            <Footer></Footer>
        </Fragment>
    )
}