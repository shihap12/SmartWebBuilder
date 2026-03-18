import React, { useEffect, useState } from "react";

const PublishedSite: React.FC<{ projectId: number }> = ({ projectId }) => {
  const [html, setHtml] = useState<string>("");

  useEffect(() => {
    fetch(`/api/projects/${projectId}/export`).then(async (r) => {
      const t = await r.text();
      setHtml(t);
    });
  }, [projectId]);

  return (
    <div className="p-6">
      <h2 className="text-2xl font-bold mb-4">Published Site Preview</h2>
      <div className="border p-4" dangerouslySetInnerHTML={{ __html: html }} />
    </div>
  );
};

export default PublishedSite;
