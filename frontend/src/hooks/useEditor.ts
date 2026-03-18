import { useState } from "react";

export function useEditor(initialContent: any = {}) {
  const [content, setContent] = useState<any>(initialContent);
  const [history, setHistory] = useState<any[]>([]);
  const [pointer, setPointer] = useState<number>(-1);

  function applyChange(newContent: any) {
    const nextHistory = history.slice(0, pointer + 1);
    nextHistory.push(newContent);
    setHistory(nextHistory);
    setPointer(nextHistory.length - 1);
    setContent(newContent);
  }

  function undo() {
    if (pointer <= 0) return;
    const p = pointer - 1;
    setPointer(p);
    setContent(history[p]);
  }

  function redo() {
    if (pointer >= history.length - 1) return;
    const p = pointer + 1;
    setPointer(p);
    setContent(history[p]);
  }

  return { content, applyChange, undo, redo, history, pointer };
}
