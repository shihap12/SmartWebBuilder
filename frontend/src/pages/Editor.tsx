import React from "react";
import EditorCanvas from "../components/EditorCanvas";
import ElementToolbar from "../components/ElementToolbar";
import StylePanel from "../components/StylePanel";

const Editor: React.FC = () => {
  return (
    <div className="flex h-screen">
      <ElementToolbar />
      <EditorCanvas />
      <StylePanel />
    </div>
  );
};

export default Editor;
