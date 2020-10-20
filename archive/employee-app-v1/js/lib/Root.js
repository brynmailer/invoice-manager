import { loadPage } from "./loadPage.js";
import { Page } from "./Page.js";
import { Router } from "./Router.js";

/**
 * The main class that handles rendering the pages
 * @extends {HTMLElement}
 */
export class Root extends HTMLElement {
  /**
   * @constructor
   */
  constructor() {
    super();
    /**
     * The router
     * @type {Router}
     */
    this._router = new Router();
    /**
     * The last known route
     * @type {string}
     */
    this._route = this._router.getRoute();
    /**
     * The current page
     * @type {Page}
     */
    this._page = null;

    // Listen for route change and navigate to the appropriate page
    this._router.eventSource.addEventListener("routechanged", async () => {
      if (this._route !== this._router.getRoute()) {
        this._route = this._router.getRoute();
        if (this._route) {
          this._page = await loadPage(this._route);
          this.renderCurrentPage();
        }
      }
    });
  }

  /**
   * Get the list of observed attributes
   * @returns {string[]} The list of attributes to watch
   */
  static get observedAttributes() {
    return ["initial-page"];
  }

  /**
   * Called when an attribute changes
   * @param {string} attrName
   * @param {string} oldVal
   * @param {string} newVal
   */
  async attributeChangedCallback(attrName, oldVal, newVal) {
    if (attrName === "initial-page") {
      if (oldVal !== newVal) {
        this._page = await loadPage(newVal);
        this.renderCurrentPage();
      }
    }
  }

  /**
   * Renders the current page to the DOM
   */
  renderCurrentPage() {
    this.innerHTML = "";
    this.appendChild(this.page.html);
    this.page.executeScripts();
    this._router.setRoute(this.page.title);
    this._route = this._router.getRoute();
    document.title = this.page.title;
  }

  /**
   * Get the current page
   * @returns {Page}
   */
  get page() {
    return this._page;
  }
}

/**
 * Register the custom app-root component
 */
export const registerRoot = () => customElements.define("app-root", Root);
