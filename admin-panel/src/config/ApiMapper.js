export const ApiMapper = {
  accessToken: {
    post: "auth/login",
  },
  refreshToken: {
    post: "auth/refresh",
  },
  profile: {
    show: "admin/profile",
    update: "admin/profile",
  },
  config: {
    index: "admin/configs?limit=",
    store: "admin/configs",
    show: "admin/configs/:id",
    update: "admin/configs/:id",
    destroy: "admin/configs/:id",
  },
  post: {
    index: "admin/posts?limit=",
    store: "admin/posts",
    show: "admin/posts/:id",
    update: "admin/posts/:id",
    destroy: "admin/posts/:id",
  },
  project: {
    index: "admin/projects?limit=",
    store: "admin/projects",
    show: "admin/projects/:id",
    update: "admin/projects/:id",
    destroy: "admin/projects/:id",
  },
};