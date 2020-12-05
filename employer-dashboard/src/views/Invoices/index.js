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
  NewInvoiceModal,
  EditInvoiceModal,
  DeleteInvoiceModal,
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

export const Invoices = () => {
  const [newModalOpen, setNewModalOpen] = useState(false);
  const [editModalOpen, setEditModalOpen] = useState(false);
  const [deleteModalOpen, setDeleteModalOpen] = useState(false);
  const [loading, setLoading] = useState(true);
  const [invoices, setInvoices] = useState([]);
  const [targetInvoice, setTargetInvoice] = useState(null);
  const { setEmployer } = useAuthContext();
  const history = useHistory();
  const axios = useAxiosContext();
  const classes = useStyles();

  useEffect(() => {
    let isCancelled = false;
    const loadInvoices = async () => {
      try {
        const response = await axios.get("/invoices");

        if (response.status === 200 && !isCancelled) {
          setInvoices(response.data);
        }
        if (!isCancelled) setLoading(false);
      } catch (error) {
        if (error.response.status === 401 && !isCancelled) {
          setEmployer(null);
          history.push("/");
        }
      }
    };

    loadInvoices();

    return () => {
      isCancelled = true;
    };
  }, [loading, setLoading, setInvoices, setEmployer, history, axios]);

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
      <NewInvoiceModal open={newModalOpen} onClose={handleNewModalClose} />
      <EditInvoiceModal
        open={editModalOpen}
        onClose={handleEditModalClose}
        invoice={targetInvoice}
      />
      <DeleteInvoiceModal
        open={deleteModalOpen}
        onClose={handleDeleteModalClose}
        invoice={targetInvoice}
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
                  <TableCell>Created</TableCell>
                  <TableCell>Updated</TableCell>
                  <TableCell>Total Work Sessions</TableCell>
                  <TableCell>Grand Total ($)</TableCell>
                  <TableCell align="right" size="small">
                    <Tooltip title="New invoice">
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
                {invoices
                  .sort((a, b) => new Date(b.created) - new Date(a.created))
                  .map((invoice) => {
                    const grandTotal = invoice.items
                      .reduce(
                        (currentTotal, invoiceItem) =>
                          currentTotal +
                          invoiceItem.workSession.employee.hourlyRate *
                            Math.ceil(
                              Math.abs(
                                new Date(invoiceItem.workSession.finish) -
                                  new Date(invoiceItem.workSession.start)
                              ) / 36e5
                            ),
                        0
                      )
                      .toString();

                    return (
                      <TableRow
                        hover
                        key={invoice.ID}
                        onClick={() => history.push(`/invoice/${invoice.ID}`)}
                      >
                        <TableCell>
                          {invoice.created.substring(
                            0,
                            invoice.created.length - 3
                          )}
                        </TableCell>
                        <TableCell>
                          {invoice.updated
                            ? invoice.updated.substring(
                                0,
                                invoice.updated.length - 3
                              )
                            : ""}
                        </TableCell>
                        <TableCell>{invoice.items.length}</TableCell>
                        <TableCell>
                          {grandTotal != 0
                            ? grandTotal.substring(0, grandTotal.length - 2) +
                              "." +
                              grandTotal.substring(grandTotal.length - 2)
                            : "0.00"}
                        </TableCell>
                        <TableCell align="right" size="small">
                          <Tooltip title="Edit invoice">
                            <IconButton
                              className={classes.tableCellAction}
                              onClick={(event) => {
                                event.stopPropagation();
                                setTargetInvoice(invoice);
                                setEditModalOpen(true);
                              }}
                            >
                              <EditIcon />
                            </IconButton>
                          </Tooltip>
                          <Tooltip title="Delete invoice">
                            <IconButton
                              className={classes.tableCellAction}
                              onClick={(event) => {
                                event.stopPropagation();
                                setTargetInvoice(invoice);
                                setDeleteModalOpen(true);
                              }}
                            >
                              <DeleteIcon />
                            </IconButton>
                          </Tooltip>
                        </TableCell>
                      </TableRow>
                    );
                  })}
              </TableBody>
            </Table>
          </TableContainer>
        )}
      </Paper>
    </>
  );
};
