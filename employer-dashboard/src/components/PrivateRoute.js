import { useEffect, useState } from "react";
import { Route, useHistory } from "react-router-dom";

import { useAuthContext, useAxiosContext } from "utils";

export const PrivateRoute = (props) => {
  const [loading, setLoading] = useState(true);
  const { setEmployer } = useAuthContext();
  const history = useHistory();
  const axios = useAxiosContext();

  useEffect(() => {
    let isCancelled = false;

    const checkAuthStatus = async () => {
      try {
        const response = await axios.get("/auth/user");
        if (response.status === 200 && !isCancelled) {
          setEmployer(response.data.employer);
          setLoading(false);
        }
      } catch (error) {
        if (error.response.status === 401 && !isCancelled) {
          setEmployer(null);
          history.push("/");
        }
      }
    };

    checkAuthStatus();

    return () => {
      isCancelled = true;
    };
  }, [setEmployer, setLoading, history, axios]);

  return loading ? <div /> : <Route {...props} />;
};
