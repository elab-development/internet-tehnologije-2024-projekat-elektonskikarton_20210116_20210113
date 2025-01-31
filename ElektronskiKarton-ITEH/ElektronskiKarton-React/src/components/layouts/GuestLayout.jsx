import {Outlet} from 'react-router-dom'
import '../../assets/css/bootstrap.min.css'


export default function GuestLayout(){
    return(
        <div>
            <Outlet></Outlet>
        </div>
    )
}