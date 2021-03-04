export const TOKEN_NAME = 'token';

export const Token = {
  set : (accessToken) => {
  return localStorage.setItem(TOKEN_NAME, JSON.stringify(accessToken));
  },
  get : () => {
    return localStorage.getItem(TOKEN_NAME);
  },
  clear: () => {
    return localStorage.removeItem(TOKEN_NAME);
  },
  clearAll: () => {
  return localStorage.clear();
  }
}