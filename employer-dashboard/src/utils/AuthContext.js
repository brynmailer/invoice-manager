import { createContext, useContext } from "react";
import { shallowEqualObjects } from "shallow-equal";

const AuthContext = createContext();

export const AuthContextProvider = ({ children }) => {
  const defaultContext = {
    employer: null,
    setEmployer: (newEmployer) => {
      if (!shallowEqualObjects(newEmployer, defaultContext.employer))
        defaultContext.employer = newEmployer;
    },
  };

  return (
    <AuthContext.Provider value={defaultContext}>
      {children}
    </AuthContext.Provider>
  );
};

export const useAuthContext = () => useContext(AuthContext);
