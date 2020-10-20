/**
 * @callback ListenerCallback
 * @param {object} newVal The new value generated
 */

/**
 * An observable value
 */
export class Observable {
  /**
   * @constructor
   * @param {object} value
   */
  constructor(value) {
    /**
     * Subscriptions
     * @type {ListenerCallback[]}
     */
    this._listeners = [];
    /**
     * The value
     * @type {object}
     */
    this._value = value;
  }

  /**
   * Notifies subscribers of new value
   */
  notify() {
    this._listeners.forEach((listener) => listener(this._value));
  }

  /**
   * Subscribe to listen for changes
   * @param {ListenerCallback} listener
   */
  subscribe(listener) {
    this._listeners.push(listener);
  }

  /**
   * Get the value of the observable
   * @returns {object} The current value
   */
  get value() {
    return this._value;
  }

  /**
   * Set the value of the observable
   * @param {object} val The new value
   */
  set value(val) {
    if (val !== this._value) {
      this._value = val;
      this.notify();
    }
  }
}

/**
 * Observable computed properties
 */
export class Computed extends Observable {
  /**
   * @constructor
   * @param {Function} value Initial computation
   * @param {Observable[]} deps Dependencies
   */
  constructor(value, deps) {
    super(value());
    const listener = () => {
      this._value = value();
      this.notify();
    };
    deps.forEach((dep) => dep.subscribe(listener));
  }

  /**
   * Get the value of the observable
   * @returns {object} The value
   */
  get value() {
    return this._value;
  }

  /**
   * Set the value of the observable
   * @param {object} _ The new value
   * @throws "Cannot set computed property"
   */
  set value(_) {
    throw "Cannot set computed property";
  }
}
