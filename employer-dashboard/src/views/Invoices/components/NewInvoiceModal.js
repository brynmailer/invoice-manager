import { useState, useEffect } from "react";
import {
  makeStyles,
  Container,
  Paper,
  Modal,
  Fade,
  Typography,
  Button,
  CircularProgress,
  Grid,
} from "@material-ui/core";
import clsx from "clsx";
import { DataGrid } from "@material-ui/data-grid";

import { useAxiosContext, formatMilliseconds } from "utils";

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
  dataGridContainer: {
    height: 400,
  },
  submitButton: {
    width: "100%",
    height: 40,
    padding: theme.spacing(0),
    marginTop: theme.spacing(3),
  },
  loadingContainer: {
    minHeight: 545,
    display: "flex",
    justifyContent: "center",
    alignItems: "center",
  },
}));

const columns = [
  { field: "employee", headerName: "Employee", width: 200 },
  { field: "project", headerName: "Project", width: 200 },
  { field: "start", headerName: "Start", width: 200 },
  { field: "finish", headerName: "Finish", width: 200 },
  { field: "duration", headerName: "Duration", width: 200 },
  { field: "description", headerName: "Description", width: 300 },
];

export const NewInvoiceModal = ({ className, open, onClose, ...rest }) => {
  const [loading, setLoading] = useState(true);
  const [workSessions, setWorkSessions] = useState([]);
  const [selectionModel, setSelectionModel] = useState([]);
  const axios = useAxiosContext();
  const classes = useStyles();

  useEffect(() => {
    let isCancelled = false;

    const getWorkSessions = async () => {
      try {
        const response = await axios.get("/work-sessions");
        if (response.status === 200 && !isCancelled) {
          setWorkSessions(response.data);
          setLoading(false);
        }
      } catch (error) {
        if (!isCancelled) {
          setLoading(false);
        }
      }
    };

    getWorkSessions();

    return () => {
      isCancelled = true;
    };
  }, [setWorkSessions, setLoading, axios]);

  const handleClick = async () => {
    try {
      setLoading(true);
      const response = await axios.post("/invoices", {
        workSessionIDs: selectionModel,
      });

      if (response.status === 201) {
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
          maxWidth="md"
          className={clsx(className, classes.root)}
          component={Paper}
          elevation={12}
          square
        >
          {loading ? (
            <Grid
              container
              spacing={2}
              direction="column"
              justify="center"
              alignItems="stretch"
            >
              <Grid className={classes.loadingContainer} item xs>
                <CircularProgress size={50} />
              </Grid>
            </Grid>
          ) : (
            <>
              <Typography className={classes.title} variant="h4" align="center">
                New Invoice
              </Typography>
              <div className={classes.dataGridContainer}>
                <DataGrid
                  columns={columns}
                  rows={workSessions.map((workSession) => ({
                    id: workSession.ID,
                    employee:
                      workSession.employee.user.firstName +
                      " " +
                      workSession.employee.user.lastName,
                    project: workSession.project.title,
                    start: workSession.start.substring(
                      0,
                      workSession.start.length - 3
                    ),
                    finish: workSession.finish.substring(
                      0,
                      workSession.finish.length - 3
                    ),
                    duration: formatMilliseconds(
                      Math.abs(
                        new Date(workSession.finish) -
                          new Date(workSession.start)
                      )
                    ),
                    description: workSession.description,
                  }))}
                  pageSize={10}
                  checkboxSelection
                  onSelectionModelChange={(newSelection) => {
                    setSelectionModel(newSelection.selectionModel);
                  }}
                  selectionModel={selectionModel}
                />
              </div>
              <Button
                className={classes.submitButton}
                variant="contained"
                color="primary"
                onClick={handleClick}
              >
                Submit
              </Button>
            </>
          )}
        </Container>
      </Fade>
    </Modal>
  );
};
