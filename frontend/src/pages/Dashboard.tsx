import React from "react";
import { useProject } from "../hooks/useProject";

const Dashboard: React.FC<{ userId?: number }> = ({ userId }) => {
  const { list } = useProject(userId);

  return (
    <div className="p-6">
      <h2 className="text-2xl font-bold mb-4">Dashboard</h2>
      <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
        {list.map((p: any) => (
          <div key={p.id} className="p-4 border rounded">
            <h3 className="font-semibold">{p.title}</h3>
            <div className="text-sm text-gray-500">{p.slug}</div>
          </div>
        ))}
      </div>
    </div>
  );
};

export default Dashboard;
