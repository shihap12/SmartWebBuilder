import React from "react";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";
import Login from "./pages/Login";
import Register from "./pages/Register";
import ForgotPassword from "./pages/ForgotPassword";
import Dashboard from "./pages/Dashboard";
import Editor from "./pages/Editor";
import TemplateMarketplace from "./pages/TemplateMarketplace";

const App: React.FC = () => {
  return (
    <Router>
      <Routes>
        <Route path="/" element={<Dashboard />} />
        <Route path="/login" element={<Login />} />
        <Route path="/register" element={<Register />} />
        <Route path="/forgot" element={<ForgotPassword />} />
        <Route path="/editor" element={<Editor />} />
        <Route path="/templates" element={<TemplateMarketplace />} />
      </Routes>
    </Router>
  );
};

export default App;
