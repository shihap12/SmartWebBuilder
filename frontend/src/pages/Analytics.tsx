import React, { useEffect } from "react";
import { useAnalytics } from "../hooks/useAnalytics";

const Analytics: React.FC<{ projectId: number }> = ({ projectId }) => {
  const { stats, getStats } = useAnalytics();

  useEffect(() => {
    getStats(projectId);
  }, [projectId]);

  return (
    <div className="p-6">
      <h2 className="text-2xl font-bold mb-4">Analytics</h2>
      <pre>{JSON.stringify(stats, null, 2)}</pre>
    </div>
  );
};

export default Analytics;
