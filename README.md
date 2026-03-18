# Smart Website Builder 🚀

## What is this?

Smart Website Builder is a lightweight mini CMS and visual website builder that enables users to create, publish and export websites quickly. It's aimed at small businesses, freelancers and hobbyists who want a WYSIWYG editor plus AI-assisted content generation and an approachable REST API.

## ✨ Features

- Live drag & drop editor
- AI content generation (Claude API / Anthropic endpoint wrapper)
- Authentication with email verification
- Template marketplace
- Analytics dashboard
- Export to HTML/CSS
- Custom domain support
- Undo/Redo history
- Mobile preview

## 🛠️ Tech Stack

| Layer    | Technology                           |
| -------- | ------------------------------------ |
| Frontend | React + TypeScript + Tailwind + GSAP |
| Backend  | PHP 8 (plain REST API, no framework) |
| Database | MySQL 8                              |
| AI       | Claude / Anthropic API               |

## 📁 Project Structure

- `database/` — SQL schema, initial migrations
  - `schema.sql` — full MySQL schema with tables and foreign keys
-- `SmartWebBuilder-backend/` — PHP REST API (renamed for XAMPP compatibility)
  - `index.php` — API entry point
  - `config/` — database and CORS configuration
  - `helpers/` — response, JWT, mailer, rate limiting
  - `models/` — User, Project, Template, Analytics, Revision models
  - `controllers/` — business logic for auth, projects, templates, analytics, AI
  - `routes/` — API route dispatcher (`routes/api.php`)
- `frontend/` — React application
  - `src/` — source code
    - `types/` — TypeScript types
    - `services/` — API and AI service wrappers
    - `hooks/` — reusable hooks (`useAuth`, `useProject`, `useEditor`, `useAnalytics`)
    - `pages/` — app pages (Login, Register, Dashboard, Editor, Analytics, etc.)
    - `components/` — editor UI components
    - `animations/` — GSAP animations
  - `package.json` — frontend dependencies and scripts
  - `tailwind.config.js` — Tailwind config

## 🚀 How to Run

### Prerequisites

- PHP 8 installed and on PATH
- Composer (for backend dependencies like PHPMailer)
- Node.js 18+ and npm/yarn for frontend
- MySQL 8 server

### Database

1. Create the database and schema:

```sql
-- run in MySQL client
SOURCE database/schema.sql;
```

2. Configure DB credentials in your environment (see `.env` variables below).

### Backend

1. Install backend dependencies (PHPMailer) via Composer in the workspace root if you plan to send emails:

```bash
composer require phpmailer/phpmailer
```

2. Configure environment variables for the backend (see **Environment Variables**).

3. Serve the PHP API (example using built-in PHP server for local development):

```bash
# If you intend to place the backend inside XAMPP htdocs, folder is renamed:
cd SmartWebBuilder-backend
php -S 0.0.0.0:8000 -t .
```

The API will be reachable at `http://localhost:8000` (adjust `APP_URL` accordingly).

### Frontend

1. Install frontend dependencies:

```bash
cd frontend
npm install
# or
yarn
```

2. Start dev server:

```bash
npm start
# or
yarn start
```

3. The React app will proxy API requests to `/api` by default. Set `REACT_APP_API_URL` if your backend runs on a different origin.

## 🔌 API Endpoints

All API endpoints are under `/api` (see `backend/routes/api.php`).

| Method | Path                               | Description                                         |
| ------ | ---------------------------------- | --------------------------------------------------- |
| GET    | `/api`                             | Health/check endpoint                               |
| POST   | `/api/auth/register`               | Register new user (name, email, password)           |
| POST   | `/api/auth/login`                  | Login user (email, password) — returns JWT          |
| GET    | `/api/auth/verify?token=...`       | Verify user email by token                          |
| POST   | `/api/auth/forgot`                 | Request password reset (email)                      |
| POST   | `/api/auth/reset`                  | Reset password (token, password)                    |
| POST   | `/api/projects`                    | Create project (user_id, template_id?, title, slug) |
| GET    | `/api/projects/list/{userId}`      | List projects for a user                            |
| GET    | `/api/projects/{id}`               | Get project details                                 |
| PATCH  | `/api/projects/{id}`               | Update project (fields or content snapshot)         |
| DELETE | `/api/projects/{id}`               | Delete project                                      |
| POST   | `/api/projects/{id}/publish`       | Publish project                                     |
| GET    | `/api/projects/{id}/export`        | Export project as static HTML                       |
| GET    | `/api/templates/marketplace`       | List public templates                               |
| GET    | `/api/templates/{id}`              | Get template by id                                  |
| POST   | `/api/templates/save`              | Save template (name, base_json, created_by)         |
| POST   | `/api/analytics/record`            | Record a site visit (project_id, country, referrer) |
| GET    | `/api/analytics/stats/{projectId}` | Get analytics stats for a project                   |
| POST   | `/api/ai/generate`                 | Generate content via AI (prompt, max_tokens)        |

## 🔐 Environment Variables

Backend environment variables (examples):

- `DB_HOST` (default: 127.0.0.1)
- `DB_PORT` (default: 3306)
- `DB_NAME` (default: smart_web_builder)
- `DB_USER` (default: root)
- `DB_PASS`
- `APP_URL` (default: http://localhost:8000)
- `JWT_SECRET` (used by JWT helper)
- `SMTP_HOST`, `SMTP_USER`, `SMTP_PASS`, `SMTP_PORT`, `SMTP_FROM`, `SMTP_FROM_NAME`
- `CLAUDE_API_KEY` (or Anthropic API key used by AIController)
- `CORS_ORIGIN` (frontend origin allowed)

Frontend environment variables:

- `REACT_APP_API_URL` (e.g. http://localhost:8000/api)

## 📝 License

MIT

## 🖼️ Screenshots

Add screenshots of the editor, dashboard, and published site inside this README or a `/docs` folder when available.

---

If you'd like, I can now: install frontend dependencies, run the dev server, or attempt to push commits to `https://github.com/shihap12/SmartWebBuilder.git` (you'll need to provide push access/token). Say which action to take next.

## Environment file

Create a `.env` file at the project root by copying `.env.example` and filling in real values before running the backend.

```bash
cp .env.example .env
# then edit .env with your credentials
```

## Quick run checklist

1. Import the database schema into your MySQL instance:

```sql
SOURCE database/schema.sql;
```

2. Create `.env` from `.env.example` and fill values.

3. (Optional) Install PHP dependencies if you use email sending:

```bash
composer install
```

4. Start the backend PHP server for development:

```bash
# folder: SmartWebBuilder-backend
cd SmartWebBuilder-backend
php -S 0.0.0.0:8000 -t .
```

5. Install and run the frontend:

```bash
cd frontend
npm install --legacy-peer-deps
npm start
```

6. Open `http://localhost:3000` for the frontend (or the port shown by the React dev server).

## Done

The repository contains a ready `.env.example` file. After you set `.env` and start both servers, the frontend will communicate with the backend at the URL set in `REACT_APP_API_URL`.
