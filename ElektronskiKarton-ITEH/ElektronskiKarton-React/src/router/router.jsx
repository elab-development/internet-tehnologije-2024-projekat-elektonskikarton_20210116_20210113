import { createBrowserRouter } from "react-router-dom";
import DefaultLayout from './../components/layouts/DefaultLayout';
import GuestLayout from './../components/layouts/GuestLayout';
import Pocetna from './../views/PocetnaPage';
import LoginPage from './../views/LoginPage';
import Dashboard from "../views/Dashboard";
import Registracija from "../views/Registracija";



const router = createBrowserRouter([
    {
        path: "",
        element: <DefaultLayout></DefaultLayout>,
        children:[
            {
                path: "/dashboard",
                element: <Dashboard></Dashboard>
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
            }
            
        ]
    }
]);

export default router;