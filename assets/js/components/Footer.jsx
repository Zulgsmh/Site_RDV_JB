import React, {useState, useEffect} from 'react';
import {FontAwesomeIcon} from '@fortawesome/react-fontawesome';
import "../../css/app.css";
import LoginPage from './LoginPage';
import { Button, ButtonToolbar } from 'react-bootstrap';


const Footer = (props) => {
    
    const [state, setState] = useState({
        displayLogin: false
    });

    const modifyState = () => {
        setState({displayLogin: !state.displayLogin});
    };


    return ( 
        <div className="main-footer">
            <div className="container">
                <div className="row">
                    <div className="col-8">
                        <p> <u>Contact & adresse :</u> </p>
                        <p className="p-footer"><u><FontAwesomeIcon icon="phone" alt="contact" className="fa-lg"/></u> 07 86 34 83 25</p>
                        <p className="p-footer"><u><FontAwesomeIcon icon="location-arrow" alt="contact" className="fa-lg"/></u> 8 Rue Henri Barbusse - 93000 - Bobigny</p>
                        <p className="p-footer"><u><FontAwesomeIcon icon="envelope" alt="contact" className="fa-lg"/></u> newjantes&turbos@gmail.com</p>
                    </div>
                    <div className="col-2">
                        <p> <u>Follow us :</u> </p>
                        <ul className="ul-footer">
                                    <li className="li-footer">
                                        <a href="#"  className="icon"><FontAwesomeIcon icon={["fab", "facebook-square"]} alt="facebook" className="fa-lg"/></a>
                                    </li>
                                    <li className="li-footer">
                                        <a href="#"  className="icon"><FontAwesomeIcon icon={["fab", "instagram-square"]} alt="Instagram" className="fa-lg" /></a>
                                    </li>
                                </ul>
                    </div>   
                </div>
                <hr className="hr-footer"/>
                <div className="row">
                    <p className="col-9 p-footer">
                        &copy;{new Date().getFullYear()} New Jantes & Turbos | All right reserved | Realized by Remy.
                    </p>
                    <div className="col mr-1">
                    {state.displayLogin ? <LoginPage show={state.displayLogin} onHide={() => {modifyState()}}/> : null}
                    <ButtonToolbar>
                    <Button className="btn btn-primary mb-2 ml-50" onClick={()=> {
                        modifyState() 
                    }} >Connexion</Button>
                    </ButtonToolbar>
                    </div>
                </div>
            </div>
        </div>
     );
}
 
export default Footer;