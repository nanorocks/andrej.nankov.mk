import axios from "axios";
import { app } from "./../config/app";
import { mapper } from "./../config/mapper";

export const accessToken = (email, password) => {
  return new Promise((resolve, reject) => {
    axios
      .post(`${app.BLOG_API_URL}${mapper.accessToken.post}`, {
        email,
        password,
      })
      .then((result) => {
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
        `${app.BLOG_API_URL}${mapper.refreshToken.post}?token=${oldAccessToken}`,
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