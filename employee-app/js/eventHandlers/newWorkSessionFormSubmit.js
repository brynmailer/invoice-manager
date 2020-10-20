import { inputInvalid } from "../inputInvalid.js";
import { formatDateTime } from "../formateDateTime.js";
import { showPage } from "../showPage.js";
import { loadWorkSessions } from "../loadWorkSessions.js";

export const newWorkSessionFormSubmit = (event) => {
  event.preventDefault();

  for (let element of event.target.elements) {
    if (inputInvalid(element)) {
      return false;
    }
  }

  const startDateTime = formatDateTime(
    document.querySelector("#new-work-session-start-date").value,
    document.querySelector("#new-work-session-start-time").value
  );
  const finishDateTime = formatDateTime(
    document.querySelector("#new-work-session-finish-date").value,
    document.querySelector("#new-work-session-finish-time").value
  );

  if (new Date(finishDateTime) < new Date(startDateTime)) {
    for (let element of event.target.elements) {
      if (
        element.id === "new-work-session-start-time" ||
        element.id === "new-work-session-start-date" ||
        element.id === "new-work-session-finish-time" ||
        element.id === "new-work-session-finish-date"
      ) {
        element.classList.add("invalid");
      }
    }

    M.toast({
      html: `Finish date and time must be later than start date and time`,
      classes: "red",
    });
    return false;
  }

  fetch("/api/auth/me", {
    method: "GET",
    mode: "same-origin",
    credentials: "include",
  })
    .then((res) => res.json())
    .then((data) => {
      fetch(`/api/employee/${data.employee.ID}/work-sessions`, {
        method: "POST",
        mode: "same-origin",
        credentials: "include",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          employeeID: data.employee.ID,
          projectID: document.querySelector("#new-work-session-project").value,
          start: startDateTime,
          finish: finishDateTime,
          description: document.querySelector("#new-work-session-description")
            .value,
        }),
      }).then(
        (res) =>
          res.status === 201 &&
          showPage("work-sessions", true, loadWorkSessions)
      );
    });
};
