import { showPage } from "../showPage.js";
import { loadWorkSessions } from "../loadWorkSessions.js";

export const loginFormSubmit = (event) => {
  event.preventDefault();

  fetch("/api/auth/login", {
    method: "POST",
    mode: "same-origin",
    credentials: "include",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      role: "employee",
      email: event.target[0].value,
      password: event.target[1].value,
    }),
  })
    .then((res) => {
      switch (res.status) {
        case 401:
          throw new Error("Login details are invalid");
        case 200:
          return res.json();
        default:
          throw new Error("An error occurred");
      }
    })
    .then((data) => {
      localStorage.setItem("employee", JSON.stringify(data.employee));
      showPage("work-sessions", true, loadWorkSessions);
    })
    .catch((err) => {
      M.toast({
        html: err.message,
        classes: "red",
      });
    });
};
