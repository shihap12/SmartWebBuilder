import { ai } from "./api";

export async function generateContent(prompt: string, max_tokens = 300) {
  const res = await ai.generate({ prompt, max_tokens });
  return res.data;
}
