import { CONN } from "./../config/app";
import axios from "axios";

const urlBuilder = (path, query="&") => {
  return (
    CONN.url +
    path +
    "?key=" +
    CONN.key +
    "&data=" +
    CONN.data +
    "&signature=" +
    CONN.signature + 
    query
  );
};

export const read = (path = "/cv", query="") => {
  const URL = (query !== "") ? urlBuilder(path, query) : urlBuilder(path);

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
