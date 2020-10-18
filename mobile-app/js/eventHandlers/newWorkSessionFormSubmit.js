export const newWorkSessionFormSubmit = (event) => {
  event.preventDefault();
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
          projectID: document.querySelector("#project").value,
          start: `${document.querySelector("#start").value} ${
            document.querySelector("#date").value
          }`,
          finish: `${document.querySelector("#finish").value} ${
            document.querySelector("#date").value
          }`,
          description: document.querySelector("#description").value,
        }),
      });
    });
};
