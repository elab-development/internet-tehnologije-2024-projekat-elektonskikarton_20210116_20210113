/* eslint-disable react/prop-types */
import { createContext, useContext, useState } from "react";

const StateContext = createContext({
    user: null,
    token: typeof window !== "undefined" ? localStorage.getItem('ACCESS_TOKEN') : null,
    setUser: () => {},
    setToken: () => {}
});

export const ContextProvider = ({ children }) => {
    const [user, _setUser] = useState({
        name: '',
        email: '',
        role: '',
        id: ''
    });
    const [token, _setToken] = useState(
        typeof window !== "undefined" ? localStorage.getItem('ACCESS_TOKEN') : null
    );

    const setToken = (newToken) => {
        _setToken(newToken); // Ažurira stanje tokena
        if (newToken) {
            localStorage.setItem('ACCESS_TOKEN', newToken); // Čuva token u localStorage
        } else {
            localStorage.removeItem('ACCESS_TOKEN'); // Uklanja token iz localStorage
        }
    };

    const setUser = (newUser) => {
        _setUser(newUser);
        if(newUser){
            localStorage.setItem('USER_NAME', newUser.name);
            localStorage.setItem('USER_EMAIL', newUser.email);
            localStorage.setItem('USER_ROLE', newUser.role);
        }else{
            localStorage.removeItem('USER_NAME');
            localStorage.removeItem('USER_EMAIL');
            localStorage.removeItem('USER_ROLE');
        }
    }

    return (
        <StateContext.Provider value={{ user, token, setUser, setToken }}>
            {children}
        </StateContext.Provider>
    );
};

export const useStateContext = () => useContext(StateContext);