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

const NewProjectSchema = Yup.object().shape({
  title: Yup.string()
    .max(255, "Title must be less than or equal to 255 characters")
    .required("Title is required"),
  client: Yup.string()
    .max(255, "Client must be less than or equal to 255 characters")
    .required("Client is required"),
});

export const NewProjectModal = ({ className, open, onClose, ...rest }) => {
  const axios = useAxiosContext();
  const classes = useStyles();

  const handleSubmit = async (values, { resetForm, setSubmitting }) => {
    try {
      const response = await axios.post("/projects", {
        ...values,
      });

      if (response.status === 201) {
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
            initialValues={{
              title: "",
              client: "",
              description: "",
            }}
            validationSchema={NewProjectSchema}
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
                      New Project
                    </Grid>
                    <Grid item>
                      <Field
                        component={TextField}
                        name="title"
                        type="text"
                        label="Title"
                        variant="outlined"
                        fullWidth
                      />
                    </Grid>
                    <Grid item>
                      <Field
                        component={TextField}
                        name="client"
                        type="text"
                        label="Client"
                        variant="outlined"
                        fullWidth
                      />
                    </Grid>
                    <Grid item>
                      <Field
                        component={TextField}
                        name="description"
                        type="text"
                        label="Description"
                        variant="outlined"
                        multiline
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
