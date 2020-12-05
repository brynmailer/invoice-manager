import {
  makeStyles,
  Drawer,
  AppBar,
  Toolbar,
  Grid,
  Typography,
  List,
  ListItem,
  ListItemText,
  ListItemIcon,
} from "@material-ui/core";
import { useLocation, useHistory } from "react-router-dom";
import clsx from "clsx";
import PersonIcon from "@material-ui/icons/Person";
import AssignmentIcon from "@material-ui/icons/Assignment";
import ReceiptIcon from "@material-ui/icons/Receipt";
import ExitToAppIcon from "@material-ui/icons/ExitToApp";

import { useAxiosContext, useAuthContext } from "utils";

const drawerWidth = 270;

const useStyles = makeStyles((theme) => ({
  root: {
    display: "flex",
    minHeight: "100%",
  },
  appBar: {
    width: `calc(100% - ${drawerWidth}px)`,
    marginLeft: drawerWidth,
  },
  drawer: {
    flexShrink: 0,
    width: drawerWidth,
  },
  drawerPaper: {
    width: drawerWidth,
  },
  drawerItem: {
    paddingLeft: theme.spacing(3),
  },
  logout: {
    color: theme.palette.primary.main,
  },
  content: {
    padding: theme.spacing(4),
  },
  toolbar: theme.mixins.toolbar,
}));

export const MainLayout = ({ children }) => {
  const { setEmployer } = useAuthContext();
  const axios = useAxiosContext();
  const location = useLocation();
  const history = useHistory();
  const classes = useStyles();

  const handleLogout = async () => {
    try {
      await axios.get("/auth/logout");
    } finally {
      setEmployer(null);
      history.push("/");
    }
  };

  return (
    <div className={classes.root}>
      <AppBar className={classes.appBar} position="fixed">
        <Toolbar>
          <Typography variant="h6">Invoice Manager</Typography>
        </Toolbar>
      </AppBar>
      <Drawer
        className={classes.drawer}
        classes={{ paper: classes.drawerPaper }}
        variant="permanent"
        anchor="left"
      >
        <div className={classes.toolbar} />
        <List>
          <ListItem
            className={classes.drawerItem}
            button
            selected={location.pathname.split("/")[1] === "employees"}
            onClick={() => history.push("/employees")}
          >
            <ListItemIcon>
              <PersonIcon />
            </ListItemIcon>
            <ListItemText primary="Employees" />
          </ListItem>
          <ListItem
            className={classes.drawerItem}
            button
            selected={location.pathname.split("/")[1] === "projects"}
            onClick={() => history.push("/projects")}
          >
            <ListItemIcon>
              <AssignmentIcon />
            </ListItemIcon>
            <ListItemText primary="Projects" />
          </ListItem>
          <ListItem
            className={classes.drawerItem}
            button
            selected={location.pathname.split("/")[1] === "invoices"}
            onClick={() => history.push("/invoices")}
          >
            <ListItemIcon>
              <ReceiptIcon />
            </ListItemIcon>
            <ListItemText primary="Invoices" />
          </ListItem>
          <ListItem
            className={clsx(classes.drawerItem, classes.logout)}
            button
            onClick={handleLogout}
          >
            <ListItemIcon>
              <ExitToAppIcon className={classes.logout} />
            </ListItemIcon>
            <ListItemText primary="Logout" />
          </ListItem>
        </List>
      </Drawer>
      <Grid container direction="column">
        <Grid item className={classes.toolbar} />
        <Grid item xs className={classes.content}>
          {children}
        </Grid>
      </Grid>
    </div>
  );
};
