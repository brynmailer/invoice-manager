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

  M.Timepicker.init(document.querySelectorAll(".timepicker"));

  M.Datepicker.init(document.querySelectorAll(".datepicker"));

  M.FormSelect.init(document.querySelectorAll("select"));
};
