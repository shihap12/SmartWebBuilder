import axios from "axios";

const api = axios.create({
  baseURL: process.env.REACT_APP_API_URL || "/api",
  headers: { "Content-Type": "application/json" },
  withCredentials: true,
});

export const auth = {
  register: (payload: any) => api.post("/auth/register", payload),
  login: (payload: any) => api.post("/auth/login", payload),
  verify: (token: string) =>
    api.get(`/auth/verify?token=${encodeURIComponent(token)}`),
  forgot: (payload: any) => api.post("/auth/forgot", payload),
  reset: (payload: any) => api.post("/auth/reset", payload),
};

export const templates = {
  marketplace: () => api.get("/templates/marketplace"),
  get: (id: number) => api.get(`/templates/${id}`),
  save: (payload: any) => api.post("/templates/save", payload),
};

export const projects = {
  create: (payload: any) => api.post("/projects", payload),
  listByUser: (userId: number) => api.get(`/projects/list/${userId}`),
  get: (id: number) => api.get(`/projects/${id}`),
  update: (id: number, payload: any) => api.patch(`/projects/${id}`, payload),
  delete: (id: number) => api.delete(`/projects/${id}`),
  publish: (id: number) => api.post(`/projects/${id}/publish`),
  export: (id: number) => api.get(`/projects/${id}/export`),
};

export const analytics = {
  record: (payload: any) => api.post("/analytics/record", payload),
  stats: (projectId: number, since?: string) =>
    api.get(
      `/analytics/stats/${projectId}${since ? "?since=" + encodeURIComponent(since) : ""}`,
    ),
};

export const ai = {
  generate: (payload: any) => api.post("/ai/generate", payload),
};

export default api;
