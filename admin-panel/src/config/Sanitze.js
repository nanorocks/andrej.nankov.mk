import Moment from "react-moment";

export const Sanitize = {
  emptySpace: function (text) {
    let sanitizeStr = "";
    const len = text.split(";").length - 1;
    text.split(";").forEach((element, index) => {
      const delimiter = index === len ? "" : ";";
      sanitizeStr += element.trim() + delimiter;
    });
    return sanitizeStr;
  },

  momentFromNow: function (dataTime) {
    dataTime = dataTime === null ? new Date().toLocaleString() : dataTime;
    return <Moment fromNow>{dataTime}</Moment>;
  },

  parseJson: function (string) {
    return JSON.parse(string);
  },

  nullToEmpty(value) {
    return value === null ? "" : value;
  },

  stringToInt(value) {
    return parseInt(value);
  },
};
