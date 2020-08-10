/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
// imports 
import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom';
import "./font-awesome-icons/index";
// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';
import { HashRouter, Switch, Route, withRouter } from 'react-router-dom';
import Navbar from './components/Navbar';
import HomePage from './pages/HomePage';
import Title from './components/Title';
import Footer from './components/Footer';
import Contact from './components/Contact';
import LoginPage from './components/LoginPage';
import AuthAPI from './services/authAPI';


AuthAPI.setup();

const App = () => {

    const [isAuthenticated, setIsAuthenticated] = useState(AuthAPI.isAuthenticated());
    const NavbarWithRouter = withRouter(Navbar);

    return(
        
        <div className="content-wrap">
        <HashRouter>
            <Title/>
                <NavbarWithRouter/>
                <Switch>
                    <Route path="/login" component={LoginPage}/>
                    <Route path="/contact" component={Contact}/>
                    <Route path="/" component={HomePage}/>
                    
                </Switch>
        
            <Footer/>
        </HashRouter>
        
        </div>

    );
};

const rootElement = document.querySelector('#app');
ReactDOM.render(<App/>, rootElement);