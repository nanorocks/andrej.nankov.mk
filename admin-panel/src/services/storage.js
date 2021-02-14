export const setToken = (accessToken) => {
  return localStorage.setItem("token", JSON.stringify(accessToken));
};

export const getToken = () => {
  return localStorage.getItem("token");
};

export const clearToken = () => {
  return localStorage.removeItem("token");
};

export const clearAll = (accessToken) => {
  return localStorage.clear();
};
