import { useState, useEffect } from "react";
import {
  makeStyles,
  Paper,
  Table,
  TableContainer,
  TableHead,
  TableBody,
  TableRow,
  TableCell,
  IconButton,
  Tooltip,
  CircularProgress,
  Grid,
} from "@material-ui/core";
import { useHistory } from "react-router-dom";
import AddIcon from "@material-ui/icons/Add";
import DeleteIcon from "@material-ui/icons/Delete";
import EditIcon from "@material-ui/icons/Edit";

import {
  NewEmployeeModal,
  EditEmployeeModal,
  DeleteEmployeeModal,
} from "./components";
import { useAxiosContext, useAuthContext } from "utils";

const useStyles = makeStyles((theme) => ({
  root: {
    padding: theme.spacing(4),
    height: "100%",
  },
  tableCellAction: {
    marginLeft: theme.spacing(1),
  },
  loadingContainer: {
    minHeight: 729,
    display: "flex",
    justifyContent: "center",
    alignItems: "center",
  },
}));

export const Employees = () => {
  const [newModalOpen, setNewModalOpen] = useState(false);
  const [editModalOpen, setEditModalOpen] = useState(false);
  const [deleteModalOpen, setDeleteModalOpen] = useState(false);
  const [loading, setLoading] = useState(true);
  const [employees, setEmployees] = useState([]);
  const [targetEmployee, setTargetEmployee] = useState(null);
  const { setEmployer } = useAuthContext();
  const history = useHistory();
  const axios = useAxiosContext();
  const classes = useStyles();

  useEffect(() => {
    let isCancelled = false;
    const loadEmployees = async () => {
      try {
        const response = await axios.get("/employees");

        if (response.status === 200 && !isCancelled) {
          setEmployees(response.data);
        }
        if (!isCancelled) setLoading(false);
      } catch (error) {
        if (error.response.status === 401 && !isCancelled) {
          setEmployer(null);
          history.push("/");
        }
      }
    };

    loadEmployees();

    return () => {
      isCancelled = true;
    };
  }, [loading, setLoading, setEmployees, setEmployer, history, axios]);

  const handleNewModalClose = () => {
    setNewModalOpen(false);
    setLoading(true);
  };

  const handleEditModalClose = () => {
    setEditModalOpen(false);
    setLoading(true);
  };

  const handleDeleteModalClose = () => {
    setDeleteModalOpen(false);
    setLoading(true);
  };

  return (
    <>
      <NewEmployeeModal open={newModalOpen} onClose={handleNewModalClose} />
      <EditEmployeeModal
        open={editModalOpen}
        onClose={handleEditModalClose}
        employee={targetEmployee}
      />
      <DeleteEmployeeModal
        open={deleteModalOpen}
        onClose={handleDeleteModalClose}
        employee={targetEmployee}
      />
      <Paper className={classes.root} elevation={4} square>
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
          <TableContainer>
            <Table>
              <TableHead>
                <TableRow>
                  <TableCell>First Name</TableCell>
                  <TableCell>Last Name</TableCell>
                  <TableCell>Email</TableCell>
                  <TableCell>Job</TableCell>
                  <TableCell>Hourly Rate ($)</TableCell>
                  <TableCell align="right" size="small">
                    <Tooltip title="New employee">
                      <IconButton
                        className={classes.tableCellAction}
                        onClick={() => setNewModalOpen(true)}
                      >
                        <AddIcon />
                      </IconButton>
                    </Tooltip>
                  </TableCell>
                </TableRow>
              </TableHead>
              <TableBody>
                {employees.map((employee) => (
                  <TableRow hover key={employee.ID}>
                    <TableCell>{employee.user.firstName}</TableCell>
                    <TableCell>{employee.user.lastName}</TableCell>
                    <TableCell>{employee.user.email}</TableCell>
                    <TableCell>{employee.job}</TableCell>
                    <TableCell>
                      {employee.hourlyRate.substring(
                        0,
                        employee.hourlyRate.length - 2
                      ) +
                        "." +
                        employee.hourlyRate.substring(
                          employee.hourlyRate.length - 2
                        )}
                    </TableCell>
                    <TableCell align="right" size="small">
                      <Tooltip title="Edit employee">
                        <IconButton
                          className={classes.tableCellAction}
                          onClick={() => {
                            setTargetEmployee(employee);
                            setEditModalOpen(true);
                          }}
                        >
                          <EditIcon />
                        </IconButton>
                      </Tooltip>
                      <Tooltip title="Delete employee">
                        <IconButton
                          className={classes.tableCellAction}
                          onClick={() => {
                            setTargetEmployee(employee);
                            setDeleteModalOpen(true);
                          }}
                        >
                          <DeleteIcon />
                        </IconButton>
                      </Tooltip>
                    </TableCell>
                  </TableRow>
                ))}
              </TableBody>
            </Table>
          </TableContainer>
        )}
      </Paper>
    </>
  );
};
