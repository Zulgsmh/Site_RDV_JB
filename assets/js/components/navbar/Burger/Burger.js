// Burger.js
import React from 'react';
import { bool, func } from 'prop-types';
import { StyledBurger } from './Burger.styled';

export const Burger = ({open, setOpen}) => {

    Burger.propTypes = {
        open: bool.isRequired,
        setOpen: func.isRequired
    };

  return (
    <StyledBurger open={open} onClick={()=> setOpen(!open)}>
      <div />
      <div />
      <div />
    </StyledBurger>
  )
}

export default Burger;