import { useState } from "react";
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
  Snackbar,
} from "@material-ui/core";
import { Alert } from "@material-ui/lab";
import clsx from "clsx";

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
  continueButton: {
    padding: theme.spacing(0),
    margin: theme.spacing(1),
    marginTop: theme.spacing(3),
  },
  loadingContainer: {
    minHeight: 170,
    display: "flex",
    justifyContent: "center",
    alignItems: "center",
  },
}));

export const DeleteProjectModal = ({
  className,
  open,
  onClose,
  project,
  ...rest
}) => {
  const [loading, setLoading] = useState(false);
  const [snackbarOpen, setSnackbarOpen] = useState(false);
  const axios = useAxiosContext();
  const classes = useStyles();

  const handleClick = async () => {
    try {
      setLoading(true);
      const response = await axios.delete(`/project/${project.ID}`);

      if (response.status === 204) {
        setLoading(false);
        onClose();
      }
    } catch (error) {
      if (error.response.status === 500) {
        setSnackbarOpen(true);
      }

      setLoading(false);
    }
  };

  const handleClose = (event, reason) => {
    if (reason === "clickaway") {
      return;
    }

    setSnackbarOpen(false);
  };

  return (
    <>
      <Snackbar
        open={snackbarOpen}
        autoHideDuration={4000}
        onClose={handleClose}
      >
        <Alert
          onClose={handleClose}
          severity="error"
          variant="filled"
          elevation={6}
        >
          This project is associated with one or more work sessions.
        </Alert>
      </Snackbar>
      <Modal open={open} onClose={onClose} closeAfterTransition {...rest}>
        <Fade in={open}>
          <Container
            maxWidth="sm"
            className={clsx(className, classes.root)}
            component={Paper}
            elevation={12}
            square
          >
            <Grid
              container
              spacing={2}
              direction="column"
              justify="center"
              alignItems="stretch"
            >
              {loading ? (
                <Grid className={classes.loadingContainer} item xs>
                  <CircularProgress size={50} />
                </Grid>
              ) : (
                <>
                  <Grid item component={Typography} variant="h4" align="center">
                    Are you sure you want to delete this project?
                  </Grid>
                  <Grid
                    className={classes.continueButton}
                    item
                    component={Button}
                    variant="contained"
                    color="primary"
                    onClick={handleClick}
                  >
                    Continue
                  </Grid>
                </>
              )}
            </Grid>
          </Container>
        </Fade>
      </Modal>
    </>
  );
};
