import { Fragment } from "react";
import { useStateContext } from "../../context/ContextProvider";
import { Container } from 'react-bootstrap';


export default function MainBanner(){

    const{user}= useStateContext();
    console.log(user);
    
    return(
        <Fragment>
            <Container fluid={true} className="mainBanner">
            Hello {user.name}
            </Container>
        </Fragment>
    )
}