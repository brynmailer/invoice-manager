import { createContext, useContext } from "react";
import axios from "axios";

const AxiosContext = createContext();

export const AxiosContextProvider = ({ children }) => {
  const defaultContext = axios.create({
    withCredentials: true,
    baseURL: "http://localhost" + process.env.REACT_APP_API_PATH,
  });

  return (
    <AxiosContext.Provider value={defaultContext}>
      {children}
    </AxiosContext.Provider>
  );
};

export const useAxiosContext = () => useContext(AxiosContext);
