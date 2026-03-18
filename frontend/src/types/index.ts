export interface User {
  id: number;
  name: string;
  email: string;
  email_verified: boolean;
  created_at: string;
}

export interface AuthResponse {
  user: User;
  token: string;
}

export interface Template {
  id: number;
  name: string;
  thumbnail?: string;
  base_json: any;
  is_public: boolean;
  created_by: number;
  created_at: string;
}

export interface Project {
  id: number;
  user_id: number;
  template_id?: number | null;
  title: string;
  slug: string;
  is_published: boolean;
  published_at?: string | null;
  custom_domain?: string | null;
  created_at: string;
}

export type ElementContent = Record<string, any>;
