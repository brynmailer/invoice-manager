import { showPage } from "../showPage.js";
import { loadWorkSessions } from "../loadWorkSessions.js";

export const deleteWorkSessionConfirmBtnClick = () => {
  const modal = document.querySelector("#delete-work-session");
  modal.style.overflowY = "hidden";
  modal.removeChild(modal.querySelector(".modal-footer"));

  const modalContent = document.createElement("div");
  modalContent.classList.add("modal-content");
  modalContent.classList.add("modal-spinner");
  const spinner = document
    .querySelector("#spinner-template")
    .content.firstElementChild.cloneNode(true);
  spinner.firstElementChild.classList.add("small");
  modalContent.appendChild(spinner);

  modal.appendChild(modalContent);

  fetch("/api/auth/me", {
    method: "GET",
    mode: "same-origin",
    credentials: "include",
  })
    .then((res) => res.status === 200 && res.json())
    .then((data) => {
      const workSessionIDContainer = document.querySelector("#delete-target");
      fetch(
        `/api/employee/${data.employee.ID}/work-session/${workSessionIDContainer.innerHTML}`,
        {
          method: "DELETE",
          mode: "same-origin",
          credentials: "include",
        }
      ).then(
        (res) =>
          res.status === 204 &&
          showPage("work-sessions", true, loadWorkSessions)
      );
    });
};
