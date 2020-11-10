export const initMaterializeComponents = () => {
  M.updateTextFields();

  M.Sidenav.init(document.querySelectorAll(".sidenav"));

  M.Collapsible.init(document.querySelectorAll(".collapsible"), {
    onOpenStart: (instance) => {
      instance.firstElementChild.lastElementChild.classList.add("open");
    },
    onCloseStart: (instance) => {
      instance.firstElementChild.lastElementChild.classList.remove("open");
    },
  });

  M.Modal.init(document.querySelectorAll(".modal"), {
    dismissible: false,
  });

  M.Timepicker.init(document.querySelectorAll(".timepicker"), {
    twelveHour: false,
  });

  M.Datepicker.init(document.querySelectorAll(".datepicker"), {
    format: "yyyy-mm-dd",
  });
};
