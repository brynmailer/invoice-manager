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
  NewProjectModal,
  EditProjectModal,
  DeleteProjectModal,
} from "./components";
import { useAxiosContext, useAuthContext } from "utils";

const useStyles = makeStyles((theme) => ({
  root: {
    padding: theme.spacing(4),
    height: "100%",
  },
  descriptionCell: {
    width: 650,
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

export const Projects = () => {
  const [newModalOpen, setNewModalOpen] = useState(false);
  const [editModalOpen, setEditModalOpen] = useState(false);
  const [deleteModalOpen, setDeleteModalOpen] = useState(false);
  const [loading, setLoading] = useState(true);
  const [projects, setProjects] = useState([]);
  const [targetProject, setTargetProject] = useState(null);
  const { setEmployer } = useAuthContext();
  const history = useHistory();
  const axios = useAxiosContext();
  const classes = useStyles();

  useEffect(() => {
    let isCancelled = false;
    const loadProjects = async () => {
      try {
        const response = await axios.get("/projects");

        if (response.status === 200 && !isCancelled) {
          setProjects(response.data);
        }
        if (!isCancelled) setLoading(false);
      } catch (error) {
        if (error.response.status === 401 && !isCancelled) {
          setEmployer(null);
          history.push("/");
        }
      }
    };

    loadProjects();

    return () => {
      isCancelled = true;
    };
  }, [loading, setLoading, setProjects, setEmployer, history, axios]);

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
      <NewProjectModal open={newModalOpen} onClose={handleNewModalClose} />
      <EditProjectModal
        open={editModalOpen}
        onClose={handleEditModalClose}
        project={targetProject}
      />
      <DeleteProjectModal
        open={deleteModalOpen}
        onClose={handleDeleteModalClose}
        project={targetProject}
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
                  <TableCell>Title</TableCell>
                  <TableCell>Client</TableCell>
                  <TableCell className={classes.descriptionCell}>
                    Description
                  </TableCell>
                  <TableCell align="right" size="small">
                    <Tooltip title="New project">
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
                {projects.map((project) => (
                  <TableRow hover key={project.ID}>
                    <TableCell>{project.title}</TableCell>
                    <TableCell>{project.client}</TableCell>
                    <TableCell className={classes.descriptionCell}>
                      {project.description}
                    </TableCell>
                    <TableCell align="right" size="small">
                      <Tooltip title="Edit project">
                        <IconButton
                          className={classes.tableCellAction}
                          onClick={() => {
                            setTargetProject(project);
                            setEditModalOpen(true);
                          }}
                        >
                          <EditIcon />
                        </IconButton>
                      </Tooltip>
                      <Tooltip title="Delete project">
                        <IconButton
                          className={classes.tableCellAction}
                          onClick={() => {
                            setTargetProject(project);
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
