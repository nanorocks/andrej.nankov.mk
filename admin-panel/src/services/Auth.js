import axios from "axios";
import { app, ApiMapper } from "../config/_index";
import { TOKEN_NAME } from "../services/_index";

export const accessToken = (email, password) => {
  return new Promise((resolve, reject) => {
    axios
      .post(`${app.BLOG_API_URL}${ApiMapper.accessToken.post}`, {
        email,
        password,
      })
      .then((result) => {
        console.log(result);
        resolve([result.status, result.data]);
      })
      .catch((err) => {
        reject([err.response.status, err.response.data]);
      });
  });
};

export const refreshToken = (oldAccessToken) => {
  return new Promise((resolve, reject) => {
    axios
      .post(
        `${app.BLOG_API_URL}${ApiMapper.refreshToken.post}?${TOKEN_NAME}=${oldAccessToken}`,
        {}
      )
      .then((result) => {
        resolve([result.status, result.data]);
      })
      .catch((err) => {
        reject([err.response.status, err.response.data]);
      });
  });
};