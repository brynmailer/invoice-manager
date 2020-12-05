export const loadWorkSessions = (template) => {
  const workSessionProjectTemplate = template.querySelector(
    "#work-session-project-template"
  );
  const workSessionTemplate = template.querySelector("#work-session-template");

  const spinner = document
    .querySelector("#spinner-template")
    .content.cloneNode(true);

  template.appendChild(spinner);

  new Promise((resolve) => setTimeout(resolve, 1000)).then(() => {
    fetch(`/api/projects`, {
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
            .querySelector("#edit-work-session-project")
            .appendChild(projectDOM);
        });

        M.FormSelect.init(template.querySelector("#edit-work-session-project"));

        projects.forEach((project) => {
          const projectDOM = workSessionProjectTemplate.content.firstElementChild.cloneNode(
            true
          );

          projectDOM.value = project.ID;

          projectDOM.innerHTML = project.title;

          template
            .querySelector("#new-work-session-project")
            .appendChild(projectDOM);
        });

        M.FormSelect.init(template.querySelector("#new-work-session-project"));
      });
  });

  new Promise((resolve) => setTimeout(resolve, 2000)).then(() => {
    fetch(`/api/work-sessions`, {
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
          ).firstElementChild.innerHTML = `${workSession.start.slice(
            0,
            16
          )} - ${workSession.finish.slice(0, 16)}`;

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

              const startTimepickerEl = template.querySelector(
                "#edit-work-session-start-time"
              );
              const startTimepickerInstance = M.Timepicker.getInstance(
                startTimepickerEl
              );
              startTimepickerEl.value = workSession.start.slice(11, 16);
              startTimepickerInstance.time = startTimepickerEl.value;

              const finishTimepickerEl = template.querySelector(
                "#edit-work-session-finish-time"
              );
              const finishTimepickerInstance = M.Timepicker.getInstance(
                finishTimepickerEl
              );
              finishTimepickerEl.value = workSession.finish.slice(11, 16);
              finishTimepickerInstance.time = finishTimepickerEl.value;

              const startDatepickerEl = template.querySelector(
                "#edit-work-session-start-date"
              );
              const startDatepickerInstance = M.Datepicker.getInstance(
                startDatepickerEl
              );
              startDatepickerInstance.setDate(new Date(workSession.start));
              startDatepickerEl.value = workSession.start.slice(0, 10);

              const finishDatepickerEl = template.querySelector(
                "#edit-work-session-finish-date"
              );
              const finishDatepickerInstance = M.Datepicker.getInstance(
                finishDatepickerEl
              );
              finishDatepickerInstance.setDate(new Date(workSession.finish));
              finishDatepickerEl.value = workSession.finish.slice(0, 10);

              const projectSelect = template.querySelector(
                "#edit-work-session-project"
              );

              projectSelect.querySelectorAll("option").forEach((project) => {
                if (project.value === workSession.projectID) {
                  projectSelect.value = project.value;
                }
              });

              template.querySelector("#edit-work-session-description").value =
                workSession.description;

              M.updateTextFields();
              M.FormSelect.init(template.querySelectorAll("select"));
              M.Modal.getInstance(editModalElement).open();
            });

          template
            .querySelector("#work-sessions-list")
            .appendChild(workSessionDOM);
        });

        template.querySelector("#work-sessions-list").hidden = false;
        template.querySelector(".spinner").hidden = true;
      });
  });
};
