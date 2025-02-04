import { Fragment } from "react";
import NavBar from './../components/common/NavBar';
import Footer from "../components/common/Footer";
import MainBanner from './../components/dashboard/MainBanner';

export default function Dashboard(){

    return(
        <Fragment>
            <NavBar></NavBar>
            <MainBanner></MainBanner>
            <Footer></Footer>
        </Fragment>
    )
}