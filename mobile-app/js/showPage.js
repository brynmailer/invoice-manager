import { initMaterializeComponents } from "./initMaterializeComponents.js";
import { registerEventListeners } from "./registerEventListeners.js";

export function showPage(pageName, navbar = true, templateProcessor) {
  const root = document.getElementById("root");
  root.innerHTML = "";

  if (navbar) {
    const navbar = document
      .querySelector("#navbar-template")
      .content.cloneNode(true);
    navbar.querySelector(`#${pageName}-nav-item`).classList.add("active");
    navbar.querySelector("#app-location").innerHTML = pageName
      .split("-")
      .map((word) => word[0].toUpperCase() + word.slice(1))
      .join(" ");
    root.appendChild(navbar);
  }

  root.appendChild(
    document.querySelector(`#${pageName}-template`).content.cloneNode(true)
  );

  if (templateProcessor) templateProcessor(root);

  initMaterializeComponents();
  registerEventListeners(pageName, navbar);
}
