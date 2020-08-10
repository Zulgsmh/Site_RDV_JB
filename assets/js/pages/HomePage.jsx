import React from 'react'
import { Link } from 'react-router-dom';

const HomePage = (props) => {
    return (
            <div className="home">
                    <p>Vos jantes sont abimées ?</p>
                    <p>Votre turbo a besoin d’être rénové?</p>
                    <p>une équipe de spécialiste se tient à votre disposition pour un travail dans les meilleurs délais.
                    Des prix compétitifs, un travail soigné !</p>
                    <p>N’hésitez pas et <u><Link className="link" to="/contact">contactez-nous</Link></u> pour prendre rdv.</p>
            </div>
    );
}
 
export default HomePage;