// // import env from 'react-dotenv';
// import { axiosInstanceAPI } from "./../helpers/axiosInstance";

// const env = {
//   API_URL: "http://iwapi.repo/api",
//   JWT_URL: "http://iwjwt.repo/api",
// };

// export function index(urlPathFromMapper, limit = 20) {
//   return new Promise((resolve, reject) => {
//     axiosInstanceAPI
//       .get(env.API_URL + urlPathFromMapper + limit, {})
//       .then((result) => {
//         resolve([result.status, result.data]);
//       })
//       .catch((err) => {
//         reject([err.response.status, err.response.data]);
//       });
//   });
// }

// export function store(urlPathFromMapper, entity) {
//   return new Promise((resolve, reject) => {
//     axiosInstanceAPI
//       .post(env.API_URL + urlPathFromMapper, entity)
//       .then((result) => {
//         resolve([result.status, result.data]);
//       })
//       .catch((err) => {
//         reject([err.response.status, err.response.data]);
//       });
//   });
// }

// export function show(urlPathFromMapper, id) {
//   return new Promise((resolve, reject) => {
//     axiosInstanceAPI
//       .get(env.API_URL + urlPathFromMapper + `${id}`, {})
//       .then((result) => {
//         resolve([result.status, result.data]);
//       })
//       .catch((err) => {
//         reject([err.response.status, err.response.data]);
//       });
//   });
// }

// export function update(urlPathFromMapper, entity, id) {
//   return new Promise((resolve, reject) => {
//     axiosInstanceAPI
//       .put(env.API_URL + urlPathFromMapper + `${id}`, entity)
//       .then((result) => {
//         resolve([result.status, result.data]);
//       })
//       .catch((err) => {
//         reject([err.response.status, err.response.data]);
//       });
//   });
// }

// export function destroy(urlPathFromMapper, id) {
//   return new Promise((resolve, reject) => {
//     axiosInstanceAPI
//       .delete(env.API_URL + urlPathFromMapper + `${id}`, {})
//       .then((result) => {
//         resolve([result.status, result.data]);
//       })
//       .catch((err) => {
//         reject([err.response.status, err.response.data]);
//       });
//   });
// }
