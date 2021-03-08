import axios from "axios";
import { app, ApiMapper } from "./_index";
import { Token } from "../services/Token";
import { refreshToken } from "../services/Auth";

axios.interceptors.response.use(
  (response) => {
    return response;
  },
  function (error) {
    const originalRequest = error.config;

    if (
      error.response.status === 401 &&
      originalRequest.url === `${app.BLOG_API_URL}${ApiMapper.refreshToken}`
    ) {
      return Promise.reject(error);
    }

    if (error.response.status === 401 && !originalRequest._retry) {
      originalRequest._retry = true;
      return refreshToken(Token.get().access_token).then((result) => {
        if (result[0] === 200) {
          axios.defaults.headers.common["Authorization"] =
            `${Token.set(result[1]).token_type} ` + Token.set(result[1]).access_token;
          return axios(originalRequest);
        }
      });
    }

    return Promise.reject(error);
  }
);

export default axios;
