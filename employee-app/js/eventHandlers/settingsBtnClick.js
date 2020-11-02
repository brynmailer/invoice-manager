import { showPage } from "../showPage.js";
import { loadSettings } from "../loadSettings.js";

export const settingsBtnClick = () => showPage("settings", true, loadSettings);
