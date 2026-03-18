import React, { useState } from "react";
import { projects } from "../services/api";

const DomainSettings: React.FC<{ projectId: number }> = ({ projectId }) => {
  const [domain, setDomain] = useState("");

  const save = async () => {
    await projects.update(projectId, { custom_domain: domain });
    alert("Saved");
  };

  return (
    <div className="p-4 border rounded">
      <h4 className="font-semibold mb-2">Custom Domain</h4>
      <input
        className="w-full p-2 border mb-2"
        value={domain}
        onChange={(e) => setDomain(e.target.value)}
        placeholder="example.com"
      />
      <button className="px-3 py-1 bg-blue-600 text-white" onClick={save}>
        Save
      </button>
    </div>
  );
};

export default DomainSettings;
