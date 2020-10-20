import { loginFormSubmit } from "./eventHandlers/loginFormSubmit.js";
import { workSessionsBtnClick } from "./eventHandlers/workSessionsBtnClick.js";
import { settingsBtnClick } from "./eventHandlers/settingsBtnClick.js";
import { logoutBtnClick } from "./eventHandlers/logoutBtnClick.js";
import { newWorkSessionFormSubmit } from "./eventHandlers/newWorkSessionFormSubmit.js";

export const registerEventListeners = (pageName, navbar) => {
  document.querySelectorAll(".timepicker,.datepicker").forEach((element) =>
    element.addEventListener("keydown", (event) => {
      event.preventDefault();
      return false;
    })
  );

  document
    .querySelectorAll("input,select,textarea")
    .forEach((element) =>
      element.addEventListener("invalid", (event) => event.preventDefault())
    );

  if (navbar) {
    document
      .getElementById("work-sessions-btn")
      .addEventListener("click", workSessionsBtnClick);

    document
      .getElementById("settings-btn")
      .addEventListener("click", settingsBtnClick);

    document
      .getElementById("logout-btn")
      .addEventListener("click", logoutBtnClick);
  }

  switch (pageName) {
    case "login":
      document
        .getElementById("login-form")
        .addEventListener("submit", loginFormSubmit);
      break;

    case "work-sessions":
      document
        .getElementById("new-work-session-form")
        .addEventListener("submit", newWorkSessionFormSubmit);
      break;
  }
};
