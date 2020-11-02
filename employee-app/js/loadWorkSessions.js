export const loadWorkSessions = (template) => {
  const workSessionProjectTemplate = template.querySelector(
    "#work-session-project-template"
  );
  const workSessionTemplate = template.querySelector("#work-session-template");

  const spinner = document
    .querySelector("#spinner-template")
    .content.cloneNode(true);

  template.appendChild(spinner);

  const employee = JSON.parse(localStorage.getItem("employee"));

  fetch(`/api/employee/${employee.ID}/projects`, {
    method: "GET",
    mode: "same-origin",
    credentials: "include",
  })
    .then((res) => res.status === 200 && res.json())
    .then((projects) => {
      projects.forEach((project) => {
        const projectDOM = workSessionProjectTemplate.content.firstElementChild.cloneNode(
          true
        );

        projectDOM.value = project.ID;

        projectDOM.innerHTML = project.title;

        template
          .querySelector("#new-work-session-project")
          .appendChild(projectDOM);

        M.FormSelect.init(template.querySelector("#new-work-session-project"));
      });
    });

  fetch(`/api/employee/${employee.ID}/work-sessions`, {
    method: "GET",
    mode: "same-origin",
    credentials: "include",
  })
    .then((res) => res.json())
    .then((workSessions) => {
      workSessions.sort((a, b) => new Date(b.start) - new Date(a.start));

      workSessions.forEach((workSession) => {
        const workSessionDOM = workSessionTemplate.content.firstElementChild.cloneNode(
          true
        );

        workSessionDOM.id = workSession.ID;

        workSessionDOM.querySelector(
          ".work-session-header"
        ).firstElementChild.innerHTML = `${workSession.start} <strong>-</strong> ${workSession.finish}`;

        workSessionDOM.querySelector(
          ".work-session-project-title"
        ).innerHTML = `<strong>Project:</strong> ${workSession.project.title}`;

        workSessionDOM.querySelector(".work-session-description").value =
          workSession.description;

        workSessionDOM
          .querySelector("a.delete-work-session-btn")
          .addEventListener("click", () => {
            const deleteModalElement = template.querySelector(
              "#delete-work-session"
            );
            localStorage.setItem("targetWorkSession", workSession.ID);
            M.Modal.getInstance(deleteModalElement).open();
          });

        workSessionDOM
          .querySelector("a.edit-work-session-btn")
          .addEventListener("click", () => {
            const editModalElement = template.querySelector(
              "#edit-work-session"
            );
            localStorage.setItem("targetWorkSession", workSession.ID);

            template.querySelector("#edit-work-session-start-time").value =
              workSession.start;

            M.Modal.getInstance(editModalElement).open();
          });

        template
          .querySelector("#work-sessions-list")
          .appendChild(workSessionDOM);
      });

      template.querySelector("#work-sessions-list").hidden = false;
      template.querySelector(".spinner").hidden = true;
    });
};
