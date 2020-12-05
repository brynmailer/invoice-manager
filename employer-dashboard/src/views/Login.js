import { useState, useEffect } from "react";
import {
  makeStyles,
  Grid,
  Paper,
  Container,
  Typography,
  Button,
  CircularProgress,
} from "@material-ui/core";
import { Alert } from "@material-ui/lab";
import { Formik, Form, Field } from "formik";
import { TextField } from "formik-material-ui";
import { Link, useHistory } from "react-router-dom";

import { useAuthContext, useAxiosContext } from "utils";

const useStyles = makeStyles((theme) => ({
  root: {
    position: "absolute",
    left: "50%",
    top: "50%",
    transform: "translate(-50%, -50%)",
    padding: theme.spacing(4),
  },
  title: {
    marginBottom: theme.spacing(5),
  },
  submitButton: {
    padding: theme.spacing(0),
    margin: theme.spacing(1),
    marginTop: theme.spacing(3),
  },
  registerLink: {
    textDecoration: "none",
    color: theme.palette.primary.main,

    "&:hover": {
      textDecoration: "underline",
    },
  },
  loadingContainer: {
    minHeight: 349,
    display: "flex",
    justifyContent: "center",
    alignItems: "center",
  },
}));

export const Login = () => {
  const [invalid, setInvalid] = useState(false);
  const [loading, setLoading] = useState(true);
  const { setEmployer } = useAuthContext();
  const axios = useAxiosContext();
  const history = useHistory();
  const classes = useStyles();

  useEffect(() => {
    let isCancelled = false;

    const checkAuthStatus = async () => {
      try {
        const response = await axios.get("/auth/user");
        if (response.status === 200 && !isCancelled) {
          setEmployer(response.data.employer);
          history.push("/employees");
        }
      } catch (error) {
        if (!isCancelled) {
          setLoading(false);
        }
      }
    };

    checkAuthStatus();

    return () => {
      isCancelled = true;
    };
  }, [setEmployer, setLoading, history, axios]);

  const handleSubmit = async (values, { resetForm, setSubmitting }) => {
    try {
      const response = await axios.post("/auth/login", {
        ...values,
        role: "employer",
      });

      if (response.status === 200) {
        setEmployer(response.data.employer);
        history.push("/employees");
      }
    } catch (error) {
      if (error.response.status === 401) {
        setInvalid(true);
      }

      setEmployer(null);
      setSubmitting(false);
      resetForm();
    }
  };

  return (
    <Container
      className={classes.root}
      maxWidth="xs"
      component={Paper}
      elevation={12}
      square
    >
      <Formik
        initialValues={{
          email: "",
          password: "",
        }}
        onSubmit={handleSubmit}
      >
        {({ isSubmitting }) => (
          <Grid
            container
            spacing={2}
            direction="column"
            justify="center"
            alignItems="stretch"
            component={Form}
          >
            {isSubmitting || loading ? (
              <Grid className={classes.loadingContainer} item xs>
                <CircularProgress size={50} />
              </Grid>
            ) : (
              <>
                <Grid
                  className={classes.title}
                  item
                  component={Typography}
                  variant="h4"
                  align="center"
                >
                  Hi There!
                </Grid>
                {invalid && (
                  <Grid item>
                    <Alert severity="error" variant="filled">
                      Login details invalid
                    </Alert>
                  </Grid>
                )}
                <Grid item>
                  <Field
                    component={TextField}
                    name="email"
                    type="text"
                    label="Email"
                    variant="outlined"
                    fullWidth
                  />
                </Grid>
                <Grid item>
                  <Field
                    component={TextField}
                    name="password"
                    type="password"
                    label="Password"
                    variant="outlined"
                    fullWidth
                  />
                </Grid>
                <Grid
                  className={classes.submitButton}
                  item
                  component={Button}
                  variant="contained"
                  color="primary"
                  type="submit"
                >
                  Login
                </Grid>
                <Grid item>
                  Need an account?{" "}
                  <Link to="/register" className={classes.registerLink}>
                    Register
                  </Link>
                </Grid>
              </>
            )}
          </Grid>
        )}
      </Formik>
    </Container>
  );
};
