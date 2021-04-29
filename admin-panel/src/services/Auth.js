import axios from "axios";
import { app, ApiMapper } from "../config/_index";
import { Token } from "../services/Token";

export const accessToken = (credentials) => {
  return new Promise((resolve, reject) => {
    axios
      .post(`${app.BLOG_API_URL}${ApiMapper.accessToken.post}`, credentials)
      .then((result) => {
        Token.set(result.data);
        axios.interceptors.request.use(
          (config) => {
            if (Token.get()) {
              config.headers["Authorization"] =
                "Bearer " + Token.get().access_token;
            }
            config.headers["Content-Type"] = "application/json";
            return config;
          },
          (error) => {
            Promise.reject(error);
          }
        );

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
        `${app.BLOG_API_URL}${ApiMapper.refreshToken.post}?token=${oldAccessToken}`,
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