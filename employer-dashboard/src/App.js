import { ThemeProvider, CssBaseline } from "@material-ui/core";
import { BrowserRouter, Switch, Route } from "react-router-dom";

import { theme } from "theme";
import { Login, Register, Employees, Invoices, Invoice, Projects } from "views";
import { Background, MainLayout, PrivateRoute } from "components";
import { AuthContextProvider, AxiosContextProvider } from "utils";

export const App = () => {
  return (
    <ThemeProvider theme={theme}>
      <CssBaseline />
      <AxiosContextProvider>
        <AuthContextProvider>
          <BrowserRouter>
            <Switch>
              <PrivateRoute path="/projects">
                <MainLayout>
                  <Projects />
                </MainLayout>
              </PrivateRoute>
              <PrivateRoute path="/invoice/:invoiceID">
                <MainLayout>
                  <Invoice />
                </MainLayout>
              </PrivateRoute>
              <PrivateRoute path="/invoices">
                <MainLayout>
                  <Invoices />
                </MainLayout>
              </PrivateRoute>
              <PrivateRoute path="/employees">
                <MainLayout>
                  <Employees />
                </MainLayout>
              </PrivateRoute>
              <Route path="/register">
                <Background>
                  <Register />
                </Background>
              </Route>
              <Route>
                <Background>
                  <Login />
                </Background>
              </Route>
            </Switch>
          </BrowserRouter>
        </AuthContextProvider>
      </AxiosContextProvider>
    </ThemeProvider>
  );
};
