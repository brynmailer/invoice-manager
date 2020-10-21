import { initMaterializeComponents } from "./initMaterializeComponents.js";
import { registerEventListeners } from "./registerEventListeners.js";

export function showPage(pageName, showNavbar = true, templateProcessor) {
  const root = document.getElementById("root");
  root.innerHTML = "";

  if (showNavbar) {
    const navbar = document.querySelector("#navbar");

    navbar
      .querySelectorAll("li.nav-item")
      .forEach((navLink) => navLink.classList.remove("active"));
    navbar.querySelector(`#${pageName}-nav-item`).classList.add("active");

    navbar.querySelector("#app-location").innerHTML = pageName
      .split("-")
      .map((word) => word[0].toUpperCase() + word.slice(1))
      .join(" ");
    navbar.hidden = false;
  } else {
    navbar.hidden = true;
  }

  root.appendChild(
    document.querySelector(`#${pageName}-template`).content.cloneNode(true)
  );

  if (templateProcessor) templateProcessor(root);

  initMaterializeComponents();
  registerEventListeners(pageName, navbar);
}
