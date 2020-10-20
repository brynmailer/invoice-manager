/**
 * A spinner component
 * @extends {HTMLElement}
 */
export class Spinner extends HTMLElement {
  /**
   * @constructor
   */
  constructor() {
    super();
    /**
     * The template string
     * @type {string}
     */
    this._template = `
      <div class="preloader-wrapper active">
        <div class="spinner-layer spinner-blue-only">
          <div class="circle-clipper left">
            <div class="circle"></div>
          </div><div class="gap-patch">
            <div class="circle"></div>
          </div><div class="circle-clipper right">
            <div class="circle"></div>
          </div>
        </div>
      </div>
    `;

    // If centered attribute is set, apply centered class
    if (this.hasAttribute("centered")) {
      this.removeAttribute("centered");
      this.classList.add("centered");
    }

    // Render the template
    this.innerHTML = this._template;
  }
}

/**
 * Register the custom app-spinner component
 */
export const registerSpinner = () =>
  customElements.define("app-spinner", Spinner);
