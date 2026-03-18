import React, { useState } from "react";
import { useAuth } from "../hooks/useAuth";

const Register: React.FC = () => {
  const { register } = useAuth();
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [message, setMessage] = useState<string | null>(null);

  const onSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    try {
      await register({ name, email, password });
      setMessage("Registered — check your email to verify");
    } catch (err: any) {
      setMessage(err?.response?.data?.error || "Registration failed");
    }
  };

  return (
    <div className="p-6 max-w-md mx-auto">
      <h2 className="text-2xl font-bold mb-4">Register</h2>
      {message && <div className="mb-2">{message}</div>}
      <form onSubmit={onSubmit}>
        <input
          className="w-full p-2 border mb-2"
          placeholder="Name"
          value={name}
          onChange={(e) => setName(e.target.value)}
        />
        <input
          className="w-full p-2 border mb-2"
          placeholder="Email"
          value={email}
          onChange={(e) => setEmail(e.target.value)}
        />
        <input
          className="w-full p-2 border mb-2"
          placeholder="Password"
          type="password"
          value={password}
          onChange={(e) => setPassword(e.target.value)}
        />
        <button className="px-4 py-2 bg-green-600 text-white" type="submit">
          Register
        </button>
      </form>
    </div>
  );
};

export default Register;
