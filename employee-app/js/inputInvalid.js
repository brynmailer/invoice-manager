export const inputInvalid = (input) => {
  const validity = input.validity;
  for (let key in validity) {
    switch (key) {
      case "valueMissing":
        if (validity.valueMissing) {
          input.classList.add("invalid");
          M.toast({
            html: `${
              document.querySelector(`label[for="${input.id}"]`).innerHTML
            } is required`,
            classes: "red",
          });
          return true;
        }

      case "typeMismatch":
        if (validity.typeMismatch) {
          input.classList.add("invalid");
          M.toast({
            html: `${
              document.querySelector(`label[for="${input.id}"]`).innerHTML
            } must be a valid ${input.type}`,
            classes: "red",
          });
          return true;
        }

      case "tooLong":
        if (validity.tooLong) {
          input.classList.add("invalid");
          M.toast({
            html: `${
              document.querySelector(`label[for="${input.id}"]`).innerHTML
            } must contain no more than ${input.maxLength} characters`,
            classes: "red",
          });
          return true;
        }

      case "tooShort":
        if (validity.tooShort) {
          input.classList.add("invalid");
          M.toast({
            html: `${
              document.querySelector(`label[for="${input.id}"]`).innerHTML
            } must contain at least ${input.minLength} characters`,
            classes: "red",
          });
          return true;
        }

      case "rangeOverflow":
        if (validity.rangeOverflow) {
          input.classList.add("invalid");
          M.toast({
            html: `${
              document.querySelector(`label[for="${input.id}"]`).innerHTML
            } must be less than or equal to ${input.max}`,

            classes: "red",
          });
          return true;
        }

      case "rangeUnderflow":
        if (validity.rangeUnderflow) {
          input.classList.add("invalid");
          M.toast({
            html: `${
              document.querySelector(`label[for="${input.id}"]`).innerHTML
            } must be less than or equal to ${input.min}`,

            classes: "red",
          });
          return true;
        }

      default:
        return false;
    }
  }
};
