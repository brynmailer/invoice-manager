import { registerRoot } from "./lib/Root.js";
import { registerSpinner } from "./components/Spinner.js";

/**
 * Register all custom components
 */
const app = () => {
  registerRoot();
  registerSpinner();
};

document.addEventListener("DOMContentLoaded", app);
