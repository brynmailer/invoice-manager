import { Page } from "./Page.js";

export async function loadPage(pageName) {
  const response = await fetch(`./pages/${pageName}.html`);
  const page = await response.text();
  return new Page(page);
}
