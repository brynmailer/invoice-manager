import { makeStyles, Grid } from "@material-ui/core";

const useStyles = makeStyles((theme) => ({
  background: {
    height: "100%",
  },
  waveExtension: {
    backgroundColor: "#6a8eae",
  },
}));

export const Background = ({ children }) => {
  const classes = useStyles();

  return (
    <>
      <Grid
        className={classes.background}
        container
        direction="column"
        justify="space-between"
      >
        <Grid item xs />
        <Grid
          item
          component="svg"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 1440 320"
        >
          <path
            fill="#6a8eae"
            fillOpacity="1"
            d="M0,64L60,85.3C120,107,240,149,360,149.3C480,149,600,107,720,96C840,85,960,107,1080,117.3C1200,128,1320,128,1380,128L1440,128L1440,320L1380,320C1320,320,1200,320,1080,320C960,320,840,320,720,320C600,320,480,320,360,320C240,320,120,320,60,320L0,320Z"
          ></path>
        </Grid>
        <Grid className={classes.waveExtension} item xs />
      </Grid>
      {children}
    </>
  );
};
