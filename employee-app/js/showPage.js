import { initMaterializeComponents } from "./initMaterializeComponents.js";
import { registerEventListeners } from "./registerEventListeners.js";

export function showPage(pageName, showNavbar = true, templateProcessor) {
  const root = document.getElementById("root");
  root.innerHTML = "";

  const navbar = document.querySelector("#navbar");
  const sidenav = document.querySelector("#sidenav");

  if (showNavbar) {
    sidenav
      .querySelectorAll("li.nav-item")
      .forEach((navLink) => navLink.classList.remove("active"));
    sidenav.querySelector(`#${pageName}-nav-item`).classList.add("active");

    navbar.querySelector("#app-location").innerHTML = pageName
      .split("-")
      .map((word) => word[0].toUpperCase() + word.slice(1))
      .join(" ");
  }

  sidenav.hidden = !showNavbar;
  navbar.hidden = !showNavbar;

  root.appendChild(
    document.querySelector(`#${pageName}-template`).content.cloneNode(true)
  );

  if (templateProcessor) templateProcessor(root);

  initMaterializeComponents();
  registerEventListeners(pageName, navbar);
}
