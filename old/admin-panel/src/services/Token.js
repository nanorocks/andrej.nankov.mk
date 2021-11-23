export const TOKEN_NAME = "token";

export const Token = {
  set: (accessToken) => {
    localStorage.setItem(TOKEN_NAME, JSON.stringify(accessToken));
    return JSON.parse(localStorage.getItem(TOKEN_NAME));
  },
  get: () => {
    return JSON.parse(localStorage.getItem(TOKEN_NAME));
  },
  clear: () => {
    return localStorage.removeItem(TOKEN_NAME);
  },
  clearAll: () => {
    return localStorage.clear();
  },
};
