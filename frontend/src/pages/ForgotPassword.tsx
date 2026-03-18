import React, { useState } from "react";
import { auth } from "../services/api";

const ForgotPassword: React.FC = () => {
  const [email, setEmail] = useState("");
  const [message, setMessage] = useState<string | null>(null);

  const onSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    try {
      await auth.forgot({ email });
      setMessage("If an account exists you will receive reset instructions");
    } catch (err: any) {
      setMessage(err?.response?.data?.error || "Request failed");
    }
  };

  return (
    <div className="p-6 max-w-md mx-auto">
      <h2 className="text-2xl font-bold mb-4">Forgot Password</h2>
      {message && <div className="mb-2">{message}</div>}
      <form onSubmit={onSubmit}>
        <input
          className="w-full p-2 border mb-2"
          placeholder="Email"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
        />
        <button className="px-4 py-2 bg-yellow-600 text-white" type="submit">
          Send reset
        </button>
      </form>
    </div>
  );
};

export default ForgotPassword;
