import axios from "axios";
import { getToken } from "../services/Token";
import { mapper } from "./ApiMapper";
import { refreshToken, setToken } from "../services/_index";

export const app = {
  BLOG_API_URL: "http://homestead.test/",
};

// // Add a request interceptor
// axios.interceptors.request.use(
//   (config) => {
//     const token = getToken().access_token;
//     if (token) {
//       config.headers["Authorization"] = "Bearer " + token;
//     }
//     config.headers["Content-Type"] = "application/json";
//     return config;
//   },
//   (error) => {
//     Promise.reject(error);
//   }
// );

// //Add a response interceptor
// axios.interceptors.response.use(
//   (response) => {
//     return response;
//   },
//   function (error) {
//     const originalRequest = error.config;

//     if (
//       error.response.status === 401 &&
//       originalRequest.url === `${app.BLOG_API_URL}${mapper.accessToken.post}`
//     ) {
//       //  router.push('/');
//       return Promise.reject(error);
//     }

//     if (error.response.status === 401 && !originalRequest._retry) {
//       originalRequest._retry = true;
//       const accessToken = getToken().access_token;
//       return refreshToken(accessToken).then((result) => {
//         console.log("NEW token", result);
//         // if (res.status === 201) {
//         //   localStorageService.setToken(res.data);
//         //   axios.defaults.headers.common["Authorization"] =
//         //     "Bearer " + localStorageService.getAccessToken();
//         //   return axios(originalRequest);
//         // }
//       });
//     }
//     return Promise.reject(error);
//   }
// );
