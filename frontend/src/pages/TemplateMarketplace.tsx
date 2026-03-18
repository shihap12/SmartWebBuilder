import React, { useEffect, useState } from "react";
import { templates } from "../services/api";

const TemplateMarketplace: React.FC = () => {
  const [list, setList] = useState<any[]>([]);

  useEffect(() => {
    templates.marketplace().then((r) => setList(r.data || []));
  }, []);

  return (
    <div className="p-6">
      <h2 className="text-2xl font-bold mb-4">Template Marketplace</h2>
      <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
        {list.map((t: any) => (
          <div key={t.id} className="border p-4 rounded">
            <img
              src={t.thumbnail}
              alt={t.name}
              className="w-full h-40 object-cover mb-2"
            />
            <h3 className="font-semibold">{t.name}</h3>
          </div>
        ))}
      </div>
    </div>
  );
};

export default TemplateMarketplace;
