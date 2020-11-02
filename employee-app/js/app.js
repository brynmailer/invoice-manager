import { checkAuthStatus } from "./checkAuthStatus.js";
import { showPage } from "./showPage.js";
import { loadWorkSessions } from "./loadWorkSessions.js";
import { loadSettings } from "./loadSettings.js";

const app = async () => {
  checkAuthStatus().then((result) => {
    loadSettings();
    if (result) {
      showPage("work-sessions", true, loadWorkSessions);
    } else {
      showPage("login", false);
    }
  });
};

document.addEventListener("DOMContentLoaded", app);
