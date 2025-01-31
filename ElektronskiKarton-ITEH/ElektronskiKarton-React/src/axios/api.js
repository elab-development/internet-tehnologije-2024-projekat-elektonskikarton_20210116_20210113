import axiosClient from './axios-client';

export const getDoctorCount = async () => {
  return axiosClient.get('/doktorCount');
};

export const getUstanoveCount = async () => {
  return axiosClient.get('/ustanoveCount');
};

export const getPatientCount = async () => {
  return axiosClient.get('/pacijentCount');
};