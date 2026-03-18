import { useState, useEffect } from "react";
import { projects } from "../services/api";

export function useProject(userId?: number) {
  const [list, setList] = useState<any[]>([]);

  useEffect(() => {
    if (!userId) return;
    projects.listByUser(userId).then((r) => setList(r.data || []));
  }, [userId]);

  const create = async (payload: any) => {
    const r = await projects.create(payload);
    return r.data;
  };

  return { list, create };
}
