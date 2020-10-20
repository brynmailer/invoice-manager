export const formatDateTime = (dateString, timeString) => {
  let result = "";

  result += dateString.slice(8, dateString.length);
  result += "-";
  switch (dateString.slice(0, 3)) {
    case "Jan":
      result += "01-";
      break;
    case "Feb":
      result += "02-";
      break;
    case "Mar":
      result += "03-";
      break;
    case "Apr":
      result += "04-";
      break;
    case "May":
      result += "05-";
      break;
    case "Jun":
      result += "06-";
      break;
    case "Jul":
      result += "07-";
      break;
    case "Aug":
      result += "08-";
      break;
    case "Sep":
      result += "09-";
      break;
    case "Oct":
      result += "10-";
      break;
    case "Nov":
      result += "11-";
      break;
    case "Dec":
      result += "12-";
      break;
  }
  result += dateString.slice(4, 6) + " ";

  if (
    Number(timeString.slice(0, 2)) === 12 &&
    Number(timeString.slice(3, 5)) >= 0 &&
    Number(timeString.slice(3, 5)) <= 59 &&
    timeString.slice(6, timeString.length) === "AM"
  ) {
    result += Number(timeString.slice(0, 2)) - 12 + ":";
  } else if (
    Number(timeString.slice(0, 2)) >= 1 &&
    Number(timeString.slice(0, 2)) <= 11 &&
    Number(timeString.slice(3, 5)) >= 0 &&
    Number(timeString.slice(3, 5)) <= 59 &&
    timeString.slice(6, timeString.length) === "PM"
  ) {
    result += Number(timeString.slice(0, 2)) + 12 + ":";
  } else {
    result += Number(timeString.slice(0, 2)) + ":";
  }
  result += timeString.slice(3, 5) + ":00";

  return result;
};
