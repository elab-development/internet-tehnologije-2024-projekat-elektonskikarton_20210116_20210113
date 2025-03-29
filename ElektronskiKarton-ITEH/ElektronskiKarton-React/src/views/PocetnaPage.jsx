import { Fragment } from 'react';
import NavBar from './../components/common/NavBar';
import Footer from './../components/common/Footer';
import TopBanner from '../components/pocetna/TopBanner';
import Usluge from '../components/pocetna/Usluge';
import Summary from '../components/pocetna/Summary';
import Artikli from '../components/pocetna/Artikli';

import '../assets/css/custom.css'


export default function Pocetna(){

    return(
        <Fragment>
            <NavBar></NavBar>
            <TopBanner></TopBanner>
            <Usluge></Usluge>
            <Summary></Summary>
            <Artikli></Artikli>
            <Footer></Footer>
        </Fragment>
    )
}