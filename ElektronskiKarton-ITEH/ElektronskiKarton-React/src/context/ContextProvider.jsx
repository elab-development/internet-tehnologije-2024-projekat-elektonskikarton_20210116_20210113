/* eslint-disable react/prop-types */
import { createContext, useContext, useState, useEffect } from "react";

const StateContext = createContext({
    user: null,
    token: null,
    setUser: () => {},
    setToken: () => {}
});

export const ContextProvider = ({ children }) => {
    // Pokušaj da učitaš korisničke podatke iz localStorage
    const storedUser = typeof window !== "undefined" ? {
        name: localStorage.getItem('USER_NAME'),
        email: localStorage.getItem('USER_EMAIL'),
        role: localStorage.getItem('USER_ROLE'),
        id: localStorage.getItem('USER_ID'),
    } : {};

    // Početno stanje
    const [user, setUserState] = useState(storedUser);
    const [token, setTokenState] = useState(
        typeof window !== "undefined" ? localStorage.getItem('ACCESS_TOKEN') : null
    );

    useEffect(() => {
        // Kada se promeni user ili token, ažuriraj localStorage
        if (user) {
            localStorage.setItem('USER_NAME', user.name);
            localStorage.setItem('USER_EMAIL', user.email);
            localStorage.setItem('USER_ROLE', user.role);
            localStorage.setItem('USER_ID', user.id);
        } else {
            // Ako nema korisnika, obriši podatke iz localStorage
            localStorage.removeItem('USER_NAME');
            localStorage.removeItem('USER_EMAIL');
            localStorage.removeItem('USER_ROLE');
            localStorage.removeItem('USER_ID');
        }

        if (token) {
            localStorage.setItem('ACCESS_TOKEN', token);
        } else {
            localStorage.removeItem('ACCESS_TOKEN');
        }
    }, [user, token]); // Ažuriraj kad god se user ili token promene

    // Funkcija za postavljanje tokena
    const setToken = (newToken) => {
        setTokenState(newToken);
    };

    // Funkcija za postavljanje korisničkih podataka
    const setUser = (newUser) => {
        setUserState(newUser);
    };

    return (
        <StateContext.Provider value={{ user, token, setUser, setToken }}>
            {children}
        </StateContext.Provider>
    );
};

export const useStateContext = () => useContext(StateContext);
