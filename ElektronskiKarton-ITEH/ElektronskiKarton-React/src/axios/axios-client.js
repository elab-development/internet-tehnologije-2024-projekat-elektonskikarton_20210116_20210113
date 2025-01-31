import axios from 'axios';

const axiosClient = axios.create({
  baseURL: 'http://localhost:8000/api/', // Postavi svoj backend URL
  timeout: 10000, // Dodaj timeout (opcionalno)
  headers: { 'Content-Type': 'application/json' }
});

// Request Interceptor za dodavanje tokena
axiosClient.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('ACCESS_TOKEN');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => Promise.reject(error) // Rukovanje greškom prilikom kreiranja zahteva
);

// Response Interceptor za rukovanje odgovorima i greškama
axiosClient.interceptors.response.use(
  (response) => response,
  (error) => {
    const { response } = error;

    if (response) {
      if (response.status === 401) {
        localStorage.removeItem('ACCESS_TOKEN');
        console.warn('Unauthorized! Token removed.');
      } else if (response.status === 500) {
        console.error('Server error.');
      }
    } else {
      console.error('Network or CORS error.');
    }

    return Promise.reject(error); // Propusti grešku dalje
  }
);

export default axiosClient;
