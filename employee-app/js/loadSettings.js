export const loadSettings = (template) => {
  if (!localStorage.getItem("isBlueMode"))
    localStorage.setItem("isBlueMode", JSON.stringify(false));

  let isBlueMode = JSON.parse(localStorage.getItem("isBlueMode"));

  if (template) {
    template.querySelector("#blue-mode-switch input").checked = isBlueMode;
  }

  const body = document.querySelector("body");
  body.className = "";
  if (isBlueMode) body.classList.add("blue");
};
