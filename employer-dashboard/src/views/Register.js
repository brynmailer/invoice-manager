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
import * as Yup from "yup";

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
  loginLink: {
    textDecoration: "none",
    color: theme.palette.primary.main,

    "&:hover": {
      textDecoration: "underline",
    },
  },
  loadingContainer: {
    minHeight: 637,
    display: "flex",
    justifyContent: "center",
    alignItems: "center",
  },
}));

const RegisterSchema = Yup.object().shape({
  email: Yup.string()
    .email("Must be a valid email")
    .required("Email is required"),
  firstName: Yup.string()
    .max(255, "First name must be less than or equal to 255 characters")
    .required("First name is required"),
  lastName: Yup.string()
    .max(255, "Last name must be less than or equal to 255 characters")
    .required("Last name is required"),
  companyName: Yup.string()
    .max(255, "Company name must be less than or equal to 255 characters")
    .required("Company name is required"),
  password: Yup.string()
    .min(5, "Password must be at least 5 characters")
    .max(50, "Password must be less than or equal to 50 characters")
    .required("Password is required"),
  confirmPassword: Yup.string()
    .required("Please confirm your password")
    .oneOf([Yup.ref("password")], "Passwords must match"),
});

export const Register = () => {
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

  const handleSubmit = async (
    { email, firstName, lastName, password, companyName },
    { resetForm, setSubmitting }
  ) => {
    try {
      const response = await axios.post("/auth/register", {
        email,
        firstName,
        lastName,
        password,
        companyName,
      });

      if (response.status === 201) {
        setEmployer(response.data.employer);
        history.push("/employees");
      }
    } catch (error) {
      if (error.response.status === 500) {
        setInvalid(true);
      }

      setEmployer(null);
      setSubmitting(false);
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
          firstName: "",
          lastName: "",
          companyName: "",
          password: "",
          confirmPassword: "",
        }}
        onSubmit={handleSubmit}
        validationSchema={RegisterSchema}
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
                  Create An Account
                </Grid>
                {invalid && (
                  <Grid item>
                    <Alert severity="error" variant="filled">
                      An account with this email already exists
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
                    name="firstName"
                    type="text"
                    label="First Name"
                    variant="outlined"
                    fullWidth
                  />
                </Grid>
                <Grid item>
                  <Field
                    component={TextField}
                    name="lastName"
                    type="text"
                    label="Last Name"
                    variant="outlined"
                    fullWidth
                  />
                </Grid>
                <Grid item>
                  <Field
                    component={TextField}
                    name="companyName"
                    type="text"
                    label="Company Name"
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
                <Grid item>
                  <Field
                    component={TextField}
                    name="confirmPassword"
                    type="password"
                    label="Confirm Password"
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
                  Register
                </Grid>
                <Grid item>
                  Already have an account?{" "}
                  <Link to="/" className={classes.loginLink}>
                    Login
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
