const VERSION = "::v1";
const PRECACHE = "invoice-manager-precache" + VERSION;
const RUNTIME = "runtime";

const FILES_TO_CACHE = [
  "./",
  "index.html",
  "css/styles.css",
  "css/materialize.css",
  "css/normalize.css",
  "js/lib/materialize.js",
  "js/eventHandlers/blueModeSwitchChange.js",
  "js/eventHandlers/deleteWorkSessionConfirmBtnClick.js",
  "js/eventHandlers/loginFormSubmit.js",
  "js/eventHandlers/logoutBtnClick.js",
  "js/eventHandlers/newWorkSessionFormSubmit.js",
  "js/eventHandlers/editWorkSessionFormSubmit.js",
  "js/eventHandlers/settingsBtnClick.js",
  "js/eventHandlers/workSessionsBtnClick.js",
  "js/app.js",
  "js/checkAuthStatus.js",
  "js/initMaterializeComponents.js",
  "js/inputInvalid.js",
  "js/loadSettings.js",
  "js/loadWorkSessions.js",
  "js/registerEventListeners.js",
  "js/showPage.js",
];

self.addEventListener("install", (event) => {
  event.waitUntil(
    caches
      .open(PRECACHE)
      .then((cache) => cache.addAll(FILES_TO_CACHE))
      .then(self.skipWaiting())
  );
});

self.addEventListener("activate", (event) => {
  const currentCaches = [PRECACHE, RUNTIME];
  event.waitUntil(
    caches
      .keys()
      .then((cacheNames) => {
        return cacheNames.filter(
          (cacheName) => !currentCaches.includes(cacheName)
        );
      })
      .then((cachesToDelete) => {
        return Promise.all(
          cachesToDelete.map((cacheToDelete) => {
            return caches.delete(cacheToDelete);
          })
        );
      })
      .then(() => self.clients.claim())
  );
});

self.addEventListener("fetch", (event) => {
  if (
    event.request.url.startsWith(self.location.origin) &&
    event.request.url.includes("/api")
  ) {
    event.respondWith(
      caches.match(event.request).then((cachedResponse) => {
        if (cachedResponse) {
          return cachedResponse;
        }

        return caches.open(RUNTIME).then((cache) => {
          return fetch(event.request).then((response) => {
            return cache.put(event.request, response.clone()).then(() => {
              return response;
            });
          });
        });
      })
    );
  }
});
