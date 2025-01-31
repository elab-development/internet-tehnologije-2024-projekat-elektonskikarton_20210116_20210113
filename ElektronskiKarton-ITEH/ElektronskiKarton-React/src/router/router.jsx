import { createBrowserRouter } from "react-router-dom";
import DefaultLayout from './../components/layouts/DefaultLayout';
import GuestLayout from './../components/layouts/GuestLayout';
import Pocetna from './../views/PocetnaPage';



const router = createBrowserRouter([
    {
        path: "/a",
        element: <DefaultLayout></DefaultLayout>
    },
    {
        path: "/",
        element: <GuestLayout></GuestLayout>,
        children:[
            {
                path: "/pocetna",
                element: <Pocetna></Pocetna>
            }
        ]
    }
]);

export default router;