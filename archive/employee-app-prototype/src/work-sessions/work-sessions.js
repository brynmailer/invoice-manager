document.addEventListener("DOMContentLoaded", () => {
  const collapsibles = document.querySelectorAll(".collapsible");
  M.Collapsible.init(collapsibles, {
    onOpenStart: (instance) => {
      instance.firstElementChild.lastElementChild.classList.add("open");
    },
    onCloseStart: (instance) => {
      instance.firstElementChild.lastElementChild.classList.remove("open");
    },
  });

  const modals = document.querySelectorAll(".modal");
  M.Modal.init(modals, {
    dismissible: false,
  });

  const timepickers = document.querySelectorAll(".timepicker");
  M.Timepicker.init(timepickers);

  const datepickers = document.querySelectorAll(".datepicker");
  M.Datepicker.init(datepickers);

  const selects = document.querySelectorAll("select");
  M.FormSelect.init(selects);
});
