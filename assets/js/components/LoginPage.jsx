import React, {useContext, useState} from 'react';
import { Link } from 'react-router-dom';
import { toast } from 'react-toastify';
import AuthContext from '../contexts/AuthContext';
import '../../css/login.css';
import Field from './forms/Field';
import {Modal, Button, Row, Col, Form} from 'react-bootstrap';
import '../../css/modal-connexion.css';

const LoginPage = (props) => {

    const {setIsAuthenticated} = useContext(AuthContext);

    const[credentials, setCredentials] = useState({
        username: "",   
        password: ""
    });
    const[error, setError] = useState("");

    //gestion des champs
    const handleChange = ({currentTarget}) => {
        const {value, name} = currentTarget;
        setCredentials({...credentials, [name]: value})
    };

    //gestion submit
    const handleSubmit = async (event) => {
        event.preventDefault();
        try {
            const data = await AuthAPI.authenticate(credentials);
            setError(""); 
            setIsAuthenticated(true);
            toast.success("Vous êtes connecté.")
            history.replace("/customers")
        } catch (error) {
            setError("Aucun compte ne possède cette adresse email ou alors les informations ne correspondent pas.");
        }
    };

    const [show, setShow] = useState(true);

    const handleClose = () => setShow(false);
    const handleShow = () => setShow(true);

    return ( <>
        {/* 
        <Button variant="primary" onClick={handleShow}>
        Connection
        </Button>
        */}
        <Modal show={show} onHide={handleClose} backdrop="static" keyboard={false}>
        <Modal.Header closeButton>
          <Modal.Title>Connexion</Modal.Title>
        </Modal.Header>
        <form onSubmit={handleSubmit}>
        <Modal.Body>
            
                <Field label="Email" type="mail" name="username" value={credentials.username} onChange={handleChange} error={error}/>
                <Field label="Mot de passe" type="password" name="password" value={credentials.password} onChange={handleChange} error=""/>
		        
        </Modal.Body>
        <Modal.Footer>
        <div className="row">
            <Link to="/">Mot de passe oublié ?</Link>
          <Button variant="secondary" onClick={handleClose} href="/">
            Retour à l'accueil
          </Button>
          <button type="submit" className="btn">Se connecter</button>
          
        </div>
        </Modal.Footer>
        </form>	
      </Modal>

      {/* 
        <div className="box">
            <form onSubmit={handleSubmit}>
		        <span className="text-center">login</span>
                <Field label="Email" type="mail" name="username" value={credentials.username} onChange={handleChange} error={error}/>
                <Field label="Mot de passe" type="password" name="password" value={credentials.password} onChange={handleChange} error=""/>
		        <button type="submit" className="btn">Se connecter</button>
                <Link to="/"/>
            </form>	
        </div>
    */}
     </>);
}
 
export default LoginPage;