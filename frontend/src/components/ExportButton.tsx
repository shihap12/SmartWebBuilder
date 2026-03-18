import React from "react";

const ExportButton: React.FC<{ projectId: number }> = ({ projectId }) => {
  const onExport = () => {
    window.open(`/api/projects/${projectId}/export`, "_blank");
  };

  return (
    <button className="px-3 py-1 bg-gray-800 text-white" onClick={onExport}>
      Export HTML
    </button>
  );
};

export default ExportButton;
