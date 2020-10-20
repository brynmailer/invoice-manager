import { checkAuthStatus } from "./checkAuthStatus.js";
import { showPage } from "./showPage.js";
import { loadWorkSessions } from "./loadWorkSessions.js";

const app = async () => {
  checkAuthStatus().then((result) => {
    if (result) {
      showPage("work-sessions", true, loadWorkSessions);
    } else {
      showPage("login", false);
    }
  });
};

document.addEventListener("DOMContentLoaded", app);
