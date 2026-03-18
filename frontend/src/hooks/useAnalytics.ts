import { useState } from "react";
import { analytics } from "../services/api";

export function useAnalytics() {
  const [stats, setStats] = useState<any>(null);

  async function record(payload: any) {
    const r = await analytics.record(payload);
    return r.data;
  }

  async function getStats(projectId: number, since?: string) {
    const r = await analytics.stats(projectId, since);
    setStats(r.data);
    return r.data;
  }

  return { stats, record, getStats };
}
