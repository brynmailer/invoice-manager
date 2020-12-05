import {
  makeStyles,
  Container,
  Paper,
  Modal,
  Fade,
  Grid,
  Typography,
  Button,
  CircularProgress,
} from "@material-ui/core";
import { Formik, Form, Field } from "formik";
import { TextField } from "formik-material-ui";
import clsx from "clsx";
import * as Yup from "yup";

import { useAxiosContext } from "utils";

const useStyles = makeStyles((theme) => ({
  root: {
    position: "absolute",
    left: "50%",
    top: "50%",
    transform: "translate(-50%, -50%)",
    padding: theme.spacing(4),
    outline: "none",
  },
  title: {
    marginBottom: theme.spacing(5),
  },
  submitButton: {
    padding: theme.spacing(0),
    margin: theme.spacing(1),
    marginTop: theme.spacing(3),
  },
  loadingContainer: {
    minHeight: 385,
    display: "flex",
    justifyContent: "center",
    alignItems: "center",
  },
}));

const EditEmployeeSchema = Yup.object().shape({
  email: Yup.string()
    .email("Must be a valid email")
    .required("Email is required"),
  firstName: Yup.string()
    .max(255, "First name must be less than or equal to 255 characters")
    .required("First name is required"),
  lastName: Yup.string()
    .max(255, "Last name must be less than or equal to 255 characters")
    .required("Last name is required"),
  password: Yup.string()
    .min(5, "Password must be at least 5 characters")
    .max(50, "Password must be less than or equal to 50 characters"),
  hourlyRate: Yup.number()
    .positive("Hourly rate must be greater than 0")
    .required("Hourly rate is required"),
  job: Yup.string().required("Job is required"),
});

export const EditEmployeeModal = ({
  className,
  open,
  onClose,
  employee,
  ...rest
}) => {
  const axios = useAxiosContext();
  const classes = useStyles();

  const handleSubmit = async (values, { resetForm, setSubmitting }) => {
    try {
      const response = await axios.put(`/employee/${employee.ID}`, {
        ...values,
        hourlyRate: values.hourlyRate.toFixed(2).replace(".", ""),
      });

      if (response.status === 200) {
        setSubmitting(false);
        onClose();
        resetForm();
      }
    } catch (error) {
      setSubmitting(false);
    }
  };

  return (
    <Modal open={open} onClose={onClose} closeAfterTransition {...rest}>
      <Fade in={open}>
        <Container
          maxWidth="sm"
          className={clsx(className, classes.root)}
          component={Paper}
          elevation={12}
          square
        >
          <Formik
            initialValues={
              employee && {
                firstName: employee.user.firstName,
                lastName: employee.user.lastName,
                email: employee.user.email,
                password: "",
                hourlyRate: parseFloat(
                  employee.hourlyRate.substring(
                    0,
                    employee.hourlyRate.length - 2
                  ) +
                    "." +
                    employee.hourlyRate.substring(
                      employee.hourlyRate.length - 2
                    )
                ),
                job: employee.job,
              }
            }
            onSubmit={handleSubmit}
            validationSchema={EditEmployeeSchema}
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
                {isSubmitting ? (
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
                      Edit Employee
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
                        name="job"
                        type="text"
                        label="Job"
                        variant="outlined"
                        fullWidth
                      />
                    </Grid>
                    <Grid item>
                      <Field
                        component={TextField}
                        name="hourlyRate"
                        type="number"
                        label="Hourly Rate ($)"
                        variant="outlined"
                        fullWidth
                      />
                    </Grid>
                    <Grid item>
                      <Field
                        component={TextField}
                        name="password"
                        type="text"
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
                      Submit
                    </Grid>
                  </>
                )}
              </Grid>
            )}
          </Formik>
        </Container>
      </Fade>
    </Modal>
  );
};
