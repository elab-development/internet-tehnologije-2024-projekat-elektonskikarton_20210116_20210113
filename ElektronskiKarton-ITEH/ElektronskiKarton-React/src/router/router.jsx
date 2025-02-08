import { createBrowserRouter } from "react-router-dom";
import DefaultLayout from './../components/layouts/DefaultLayout';
import GuestLayout from './../components/layouts/GuestLayout';
import Pocetna from './../views/PocetnaPage';
import LoginPage from './../views/LoginPage';
import Dashboard from "../views/Dashboard";
import Registracija from "../views/Registracija";
import MojiPodaci from "../views/MojiPodaciPage";
import KartonPage from "../views/KartonPage";
import UstanovePage from "../views/UstanovePage";
import PacijentiPage from "../views/PacijentiPage";
import KreirajKartonPage from "../views/KreirajKartonPage";
import KreirajPregledPage from "../views/KreirajPregledPage";
import DoktoriPage from "../views/DoktoriPage";
import DodajDoktoraPage from "../views/DodajDoktoraPage";
import AzurirajDoktoraPage from "../views/AzurirajDoktoraPage";
import SestrePage from "../views/SestrePage";
import DodajSestruPage from "../views/DodajSestruPage";
import AzurirajSestruPage from "../views/AzurirajSestruPage";

const router = createBrowserRouter([
    {
        path: "/",
        element: <DefaultLayout></DefaultLayout>,
        children:[
            {
                path: "/dashboard",
                element: <Dashboard></Dashboard>
            },
            {
                path: "/pacijent/:id",
                element: <MojiPodaci></MojiPodaci>
            },
            {
                path: "/karton/:id",
                element: <KartonPage></KartonPage>
            },
            {
                path: "/pacijenti",
                element: <PacijentiPage></PacijentiPage>
            },
            {
                path: "/kreiraj-karton",
                element: <KreirajKartonPage></KreirajKartonPage>
            },
            {
                path: "/kreiraj-pregled",
                element: <KreirajPregledPage></KreirajPregledPage>
            },
            {
                path: "/doktori",
                element: <DoktoriPage></DoktoriPage>
            },
            {
                path: "/dodaj-doktora",
                element: <DodajDoktoraPage></DodajDoktoraPage>
            },
            {
                path: "azuriraj-doktora/:id",
                element: <AzurirajDoktoraPage></AzurirajDoktoraPage>
            },
            {
                path: "/sestre",
                element: <SestrePage></SestrePage>
            },
            {
                path: "/dodaj-sestru",
                element: <DodajSestruPage></DodajSestruPage>
            },
            {
                path: "azuriraj-sestru/:id",
                element: <AzurirajSestruPage></AzurirajSestruPage>
            },
        ]
    },
    
    {
        path: "/",
        element: <GuestLayout></GuestLayout>,
        children:[
            {
                path: "/pocetna",
                element: <Pocetna></Pocetna>
            },
            {
                path: "/login",
                element: <LoginPage></LoginPage>
            },
            {
                path: "/register",
                element: <Registracija></Registracija>
            },
            {
                path: "/ustanove",
                element: <UstanovePage></UstanovePage>
            }
            
        ]
    }
]);

export default router;