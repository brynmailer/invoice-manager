import { inputInvalid } from "../inputInvalid.js";
import { showPage } from "../showPage.js";
import { loadWorkSessions } from "../loadWorkSessions.js";

export const editWorkSessionFormSubmit = (event) => {
  event.preventDefault();

  for (let element of event.target.elements) {
    if (inputInvalid(element)) {
      return false;
    }
  }

  const startDateTime =
    document.querySelector("#edit-work-session-start-date").value +
    " " +
    document.querySelector("#edit-work-session-start-time").value +
    ":00";
  const finishDateTime =
    document.querySelector("#edit-work-session-finish-date").value +
    " " +
    document.querySelector("#edit-work-session-finish-time").value +
    ":00";

  if (new Date(finishDateTime) < new Date(startDateTime)) {
    for (let element of event.target.elements) {
      if (
        element.id === "edit-work-session-start-time" ||
        element.id === "edit-work-session-start-date" ||
        element.id === "edit-work-session-finish-time" ||
        element.id === "edit-work-session-finish-date"
      ) {
        element.classList.add("invalid");
      }
    }

    M.toast({
      html: `Work session must finish after it starts`,
      classes: "red",
    });
    return false;
  }

  const employee = JSON.parse(localStorage.getItem("employee"));
  const targetWorkSession = localStorage.getItem("targetWorkSession");

  fetch(`/api/employee/${employee.ID}/work-session/${targetWorkSession}`, {
    method: "PUT",
    mode: "same-origin",
    credentials: "include",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      ID: targetWorkSession,
      employeeID: employee.ID,
      projectID: document.querySelector("#edit-work-session-project").value,
      start: startDateTime,
      finish: finishDateTime,
      description: document.querySelector("#edit-work-session-description")
        .value,
    }),
  }).then(
    (res) =>
      res.status === 200 && showPage("work-sessions", true, loadWorkSessions)
  );
};
