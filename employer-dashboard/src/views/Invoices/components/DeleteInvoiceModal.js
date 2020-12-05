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
} from "@material-ui/core";
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

export const DeleteInvoiceModal = ({
  className,
  open,
  onClose,
  invoice,
  ...rest
}) => {
  const [loading, setLoading] = useState(false);
  const axios = useAxiosContext();
  const classes = useStyles();

  const handleClick = async () => {
    try {
      setLoading(true);
      const response = await axios.delete(`/invoice/${invoice.ID}`);

      if (response.status === 204) {
        setLoading(false);
        onClose();
      }
    } catch (error) {
      setLoading(false);
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
                  Are you sure you want to delete this invoice?
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
  );
};
