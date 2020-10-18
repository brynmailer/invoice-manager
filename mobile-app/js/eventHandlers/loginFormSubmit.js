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
  }).then((res) => {
    switch (res.status) {
      case 401:
        M.toast({
          html: "Login details are invalid",
          classes: "red",
        });
        break;
      case 200:
        showPage("work-sessions", true, loadWorkSessions);
        break;
    }
  });
};
