import { loadSettings } from "../loadSettings.js";

export const blueModeSwitchChange = (event) => {
  localStorage.setItem("isBlueMode", JSON.stringify(event.target.checked));
  loadSettings();
};
