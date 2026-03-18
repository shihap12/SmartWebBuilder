import { useState } from "react";
import { auth } from "../services/api";

export function useAuth() {
  const [user, setUser] = useState<any | null>(null);
  const [token, setToken] = useState<string | null>(null);

  async function register(payload: any) {
    const r = await auth.register(payload);
    return r.data;
  }

  async function login(payload: any) {
    const r = await auth.login(payload);
    setUser(r.data.user);
    setToken(r.data.token);
    return r.data;
  }

  function logout() {
    setUser(null);
    setToken(null);
  }

  return { user, token, register, login, logout };
}
