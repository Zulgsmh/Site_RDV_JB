import React from 'react';
import '../../css/contact.css';
import { useState } from 'react';
import {FontAwesomeIcon} from '@fortawesome/react-fontawesome';


const Contact = (props) => {

    const [message, setmessage] = useState({
        
    });
      
    return (
        <div className="container-contact">
            <div className="container-title-contact">
                <h1 className="title-contact">Contactez nous</h1>
            </div>
            {/* Container for wallpaper */}
            <div className="container-content-contact">
                {/* Container with my form*/}
                <div className="container container-form">
                    <div className="row">
                        <div className="col-8 contact-form">
                            <h1 className="contact-form-title">Prenez rendez-vous</h1>
                        </div>
                        <div className="col-4 contact-info">
                            <h1 className="contact-info-title">Info</h1>
                            <p><FontAwesomeIcon icon="location-arrow" alt="contact" className="fa-lg"/> 8 Rue Henri Barbusse</p>
                            <p>93000, Bobigny</p>
                            <p><FontAwesomeIcon icon="phone" alt="contact" className="fa-lg"/> 07 86 34 83 25 </p>
                            <p><FontAwesomeIcon icon="envelope" alt="contact" className="fa-lg"/> newjantes&turbos@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
     );
}
 
export default Contact;