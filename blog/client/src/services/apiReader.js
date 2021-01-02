import { CONN } from "./../config/app";
import axios from "axios";

export const read = (path = "/cv") => {
  const URL =
    CONN.url+ 
    path +
    "?key=" +
    CONN.key +
    "&data=" +
    CONN.data +
    "&signature=" +
    CONN.signature;

  return new Promise((resolve, reject) => {
    axios
      .get(URL)
      .then((result) => {
        resolve(result.data);
      })
      .catch((error) => {
        reject(error);
      });
  });
};
