import { showPage } from "../showPage.js";

export const logoutBtnClick = () => {
  fetch("/api/auth/logout", {
    method: "GET",
    mode: "same-origin",
    credentials: "include",
  }).then((res) => {
    switch (res.status) {
      case 200:
        showPage("login", false);
        break;
    }
  });
};
