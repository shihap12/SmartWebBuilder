import React from "react";

const ElementToolbar: React.FC = () => {
  return (
    <aside className="w-48 bg-white border-r p-4">
      <button className="w-full mb-2 p-2 border">Add Section</button>
      <button className="w-full mb-2 p-2 border">Add Text</button>
      <button className="w-full mb-2 p-2 border">Add Image</button>
    </aside>
  );
};

export default ElementToolbar;
