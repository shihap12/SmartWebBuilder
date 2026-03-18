import React, { useState } from "react";
import { generateContent } from "../services/ai";

const AIAssistant: React.FC = () => {
  const [prompt, setPrompt] = useState("");
  const [result, setResult] = useState<any>(null);

  const run = async () => {
    const r = await generateContent(prompt);
    setResult(r);
  };

  return (
    <div className="p-4 border rounded">
      <h4 className="font-semibold mb-2">AI Assistant</h4>
      <textarea
        className="w-full p-2 border mb-2"
        value={prompt}
        onChange={(e) => setPrompt(e.target.value)}
      />
      <button className="px-3 py-1 bg-indigo-600 text-white" onClick={run}>
        Generate
      </button>
      {result && (
        <pre className="mt-2 text-sm">{JSON.stringify(result, null, 2)}</pre>
      )}
    </div>
  );
};

export default AIAssistant;
