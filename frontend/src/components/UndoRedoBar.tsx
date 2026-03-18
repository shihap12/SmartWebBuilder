import React from "react";

const UndoRedoBar: React.FC<{ onUndo?: () => void; onRedo?: () => void }> = ({
  onUndo,
  onRedo,
}) => {
  return (
    <div className="flex space-x-2 p-2">
      <button className="px-3 py-1 border" onClick={onUndo}>
        Undo
      </button>
      <button className="px-3 py-1 border" onClick={onRedo}>
        Redo
      </button>
    </div>
  );
};

export default UndoRedoBar;
