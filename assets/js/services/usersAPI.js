import axios from 'axios';
import {USERS_API} from '../config';

function create(user){
    return(
        axios.post(USERS_API, user)
    );
}

function modify(user){
    return(
        axios.patch(USERS_API, user)
    );
}

export default {
    create,
    modify
};