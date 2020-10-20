import { DataBinding } from "./DataBinding.js";

/**
 * A page of the application
 */
export class Page {
  /**
   * @constructor
   * @param {string} text The content of the page
   */
  constructor(text) {
    /**
     * Internal text representation of the page
     * @type {string}
     */
    this._text = text;
    /**
     * Context for embedded scripts
     * @type {object}
     */
    this._context = {};
    /**
     * Data binding helper
     * @type {DataBinding}
     */
    this._dataBinding = new DataBinding();
    /**
     * The HTML DOM representation of the page
     * @type {HTMLDivElement}
     */
    this._html = document.createElement("div");
    this._html.innerHTML = this._text;
    /**
     * The page title
     * @type {string}
     */
    this._title = this._html.querySelector("title").innerText;
    /**
     * Embedded scripts
     * @type {HTMLScriptElement}
     */
    this._script = this._html.querySelector("script");
  }

  /**
   * Execute any embedded scripts
   */
  executeScripts() {
    if (this._script) {
      this._dataBinding.executeInContext(
        this._script.innerText,
        this._context,
        true
      );
      this._dataBinding.bindAll(this._html, this._context);
    }
  }

  /**
   * Get the HTML DOM node for the page
   * @returns {HTMLDivElement}
   */
  get html() {
    return this._html;
  }

  /**
   * Get the page title
   * @returns {string}
   */
  get title() {
    return this._title;
  }
}
