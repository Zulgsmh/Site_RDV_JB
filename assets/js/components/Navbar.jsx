import React, {useState, useEffect} from 'react';
import { NavLink } from 'react-router-dom';
import { toast } from 'react-toastify';
import AuthContext from '../contexts/AuthContext';
import AuthAPI from '../services/authAPI';
//for hamburger
import {ThemeProvider} from 'styled-components';
import {theme} from '../components/navbar/theme';
import { Burger } from '../components/navbar/Burger/Burger';
import { Menu } from '../components/navbar/Menu/Menu';
import { useRef } from 'react';
import { useOnClickOutside } from '../components/navbar/hook';
import Media from 'react-media';
//css
import "../../css/navbar_anon.css";

const Navbar = (props) => {

    const [open, setOpen] = useState(false);
    const node = useRef();
    useOnClickOutside(node, () => setOpen(false));

    return ( 
        <ThemeProvider theme={theme}>
            <div className="nav-custom">
            <Media query="(min-width: 991px)">
                {matches => {
                    return (
                        matches ?      
                            (<nav className="navbar navbar-expand-lg navbar bg">
                {/* <a className="navbar-brand" href="#"></a>
                <button className="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                    <span className="navbar-toggler-icon"></span>
                </button> */}

                {/* <div className="collapse navbar-collapse" id="navbarColor01"> */}
                    <ul className="navbar-nav mr-auto">
                    <li className="nav-item licolor">
                        <a data-page="Accueil" className="nav-link other" href="#">Accueil</a>
                    </li>
                    <li className="nav-item">
                        <a data-page="Nos services" className="nav-link other" href="#">Nos services</a>
                    </li>
                    <li className="nav-item">
                        <a data-page="A propos de nous" className="nav-link other" href="#">A propos de nous</a>
                    </li>
                    <li className="nav-item">
                        <a data-page="Nous contacter" className="nav-link contact" href="#">Nous contacter</a>
                    </li>
                    </ul>
                {/* </div> */ }
            </nav>)
                            : 
                            (<div ref={node} className="nav-ham">
                                <Burger open={open} setOpen={setOpen} />
                                <Menu open={open} setOpen={setOpen} />
                            </div>));    
                                    
                }}
            </Media>
            </div>
        </ThemeProvider>
     );
}
 
export default Navbar;