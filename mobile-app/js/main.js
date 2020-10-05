document.addEventListener("DOMContentLoaded", () => {
  M.updateTextFields();
});

// Navbar
const pages = document.querySelectorAll(".page");

const showPage = (page) => {
  document.querySelector(".app-location").innerHTML = page.id
    .split("-")
    .map((word) => word[0].toUpperCase() + word.slice(1))
    .join(" ");

  if (page.id !== "work-sessions")
    document.getElementById("new-work-session-btn").hidden = true;
  else document.getElementById("new-work-session-btn").hidden = false;

  pages.forEach((page) => {
    page.hidden = true;
  });

  page.hidden = false;
};

const settingsBtn = document.getElementById("settings-btn");
const workSessionsBtn = document.getElementById("work-sessions-btn");

settingsBtn.addEventListener("click", () =>
  showPage(document.getElementById("settings"))
);

workSessionsBtn.addEventListener("click", () =>
  showPage(document.getElementById("work-sessions"))
);

document.addEventListener("DOMContentLoaded", () => {
  showPage(document.getElementById("work-sessions"));

  const sidenavs = document.querySelectorAll(".sidenav");
  M.Sidenav.init(sidenavs);
});

// Work Sessions
document.addEventListener("DOMContentLoaded", () => {
  const collapsibles = document.querySelectorAll(".collapsible");
  M.Collapsible.init(collapsibles, {
    onOpenStart: (instance) => {
      instance.firstElementChild.lastElementChild.classList.add("open");
    },
    onCloseStart: (instance) => {
      instance.firstElementChild.lastElementChild.classList.remove("open");
    },
  });

  const modals = document.querySelectorAll(".modal");
  M.Modal.init(modals, {
    dismissible: false,
  });

  const timepickers = document.querySelectorAll(".timepicker");
  M.Timepicker.init(timepickers);

  const datepickers = document.querySelectorAll(".datepicker");
  M.Datepicker.init(datepickers);

  const selects = document.querySelectorAll("select");
  M.FormSelect.init(selects);
});
