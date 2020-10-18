import { showPage } from "../showPage.js";
import { loadWorkSessions } from "../loadWorkSessions.js";

export const workSessionsBtnClick = () =>
  showPage("work-sessions", true, loadWorkSessions);
