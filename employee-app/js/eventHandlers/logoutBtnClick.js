import { showPage } from "../showPage.js";

export const logoutBtnClick = () => {
  fetch("/api/auth/logout", {
    method: "GET",
    mode: "same-origin",
    credentials: "include",
  }).then((res) => {
    switch (res.status) {
      case 200:
        localStorage.removeItem("employee");
        showPage("login", false);
        break;
    }
  });
};
