# Praktix Backend API

A RESTful API backend for the **Praktix** platform — an Albanian tech education and career development platform offering programs, expert mentoring, and employer partnerships.

Built with **Laravel 11**, **MySQL**, and **Laravel Sanctum** for authentication.

---

## Table of Contents

- [Architecture](#architecture)
- [Database Schema](#database-schema)
- [Local Setup](#local-setup)
- [Deployment (Railway)](#deployment-railway)
- [API Endpoints](#api-endpoints)
- [Authentication](#authentication)
- [Sample Requests](#sample-requests)
- [Assumptions](#assumptions)

---

## Architecture

```
praktix/
├── app/
│   ├── Http/
│   │   ├── Controllers/Api/     # All API controllers
│   │   │   ├── AuthController.php
│   │   │   ├── ProgramController.php
│   │   │   ├── ExpertController.php
│   │   │   ├── ApplicationController.php
│   │   │   └── EmployerRequestController.php
│   │   └── Requests/            # Form Request validators
│   └── Models/                  # Eloquent models
│       ├── Admin.php
│       ├── Expert.php
│       ├── Program.php
│       ├── Application.php
│       └── EmployerRequest.php
├── database/
│   ├── migrations/              # All DB migrations
│   └── seeders/                 # Sample data seeder
└── routes/
    └── api.php                  # All API routes
```

**Design decisions:**
- **Laravel 11** with minimal setup (no unnecessary service providers)
- **Laravel Sanctum** for token-based API authentication (no JWTs needed)
- **Form Requests** for clean, centralized validation
- **Eloquent ORM** for all DB interactions with proper relationships
- Public routes (read programs, submit application) require no auth
- All write/admin routes are protected behind Sanctum middleware

---

## Database Schema

### Tables & Relationships

```
admins
  id, name, email, password, created_at, updated_at

experts
  id, name, title, specialization, experience, bio, profile_image, created_at, updated_at

programs
  id, title, category, description, duration, price, image_url,
  expert_id (FK → experts), certificate_included, created_at, updated_at

applications
  id, full_name, email, phone, program_id (FK → programs),
  cv_url, status [new|under_review|accepted|rejected], notes, created_at, updated_at

employer_requests
  id, company_name, contact_person, email,
  request_type [internship|hiring|corporate_training|ai_workshop],
  message, status [pending|in_progress|resolved], created_at, updated_at
```

### Relationships

- `Expert` → hasMany → `Programs`
- `Program` → belongsTo → `Expert`
- `Program` → hasMany → `Applications`
- `Application` → belongsTo → `Program`
- `EmployerRequest` is standalone

---

## Local Setup

### Requirements
- PHP 8.2+
- Composer
- MySQL 8.0+

### Steps

```bash
# 1. Clone the repo
git clone https://github.com/your-username/praktix-backend.git
cd praktix-backend

# 2. Install dependencies
composer install

# 3. Set up environment
cp .env.example .env
php artisan key:generate

# 4. Configure your database in .env
DB_DATABASE=praktix
DB_USERNAME=root
DB_PASSWORD=your_password

# 5. Run migrations and seed sample data
php artisan migrate
php artisan db:seed

# 6. Start the server
php artisan serve
```

The API will be available at: `http://localhost:8000/api`

---

## Deployment (Railway)

1. Push code to GitHub
2. Go to [railway.app](https://railway.app) → New Project → Deploy from GitHub repo
3. Add a **MySQL** plugin to your project
4. Set environment variables in Railway dashboard:

```
APP_NAME=Praktix
APP_ENV=production
APP_DEBUG=false
APP_KEY=             # generate with: php artisan key:generate --show
DB_CONNECTION=mysql
DB_HOST=             # from Railway MySQL plugin
DB_PORT=3306
DB_DATABASE=railway
DB_USERNAME=         # from Railway MySQL plugin
DB_PASSWORD=         # from Railway MySQL plugin
```

Railway will auto-detect the `nixpacks.toml`, install PHP, run migrations, seed, and start the server.

---

## API Endpoints

### Base URL
```
Local:      http://localhost:8000/api
Production: https://your-app.up.railway.app/api
```

### Health Check

| Method | Endpoint     | Auth | Description |
|--------|-------------|------|-------------|
| GET    | `/health`   | No   | API status  |

---

### Authentication

| Method | Endpoint       | Auth | Description         |
|--------|---------------|------|---------------------|
| POST   | `/auth/login`  | No   | Admin login         |
| POST   | `/auth/logout` | Yes  | Logout (revoke token)|
| GET    | `/auth/me`     | Yes  | Get current admin   |

---

### Programs

| Method | Endpoint             | Auth | Description              |
|--------|---------------------|------|--------------------------|
| GET    | `/programs`          | No   | List all programs        |
| GET    | `/programs/{id}`     | No   | Get program by ID        |
| POST   | `/programs`          | Yes  | Create program           |
| PUT    | `/programs/{id}`     | Yes  | Update program           |
| DELETE | `/programs/{id}`     | Yes  | Delete program           |

**Query params (GET /programs):** `?category=AI`, `?search=python`

---

### Experts

| Method | Endpoint             | Auth | Description         |
|--------|---------------------|------|---------------------|
| GET    | `/experts`           | No   | List all experts    |
| GET    | `/experts/{id}`      | No   | Get expert with programs |
| POST   | `/experts`           | Yes  | Create expert       |
| PUT    | `/experts/{id}`      | Yes  | Update expert       |
| DELETE | `/experts/{id}`      | Yes  | Delete expert       |

---

### Applications

| Method | Endpoint                          | Auth | Description               |
|--------|----------------------------------|------|---------------------------|
| POST   | `/applications`                   | No   | Student submits application|
| GET    | `/applications`                   | Yes  | List all applications     |
| GET    | `/applications/{id}`              | Yes  | Get single application    |
| PATCH  | `/applications/{id}/status`       | Yes  | Update application status |
| DELETE | `/applications/{id}`              | Yes  | Delete application        |

**Query params (GET /applications):** `?status=new`, `?program_id=1`

**Status values:** `new` → `under_review` → `accepted` | `rejected`

---

### Employer Requests

| Method | Endpoint                               | Auth | Description                  |
|--------|---------------------------------------|------|------------------------------|
| POST   | `/employer-requests`                   | No   | Company submits request      |
| GET    | `/employer-requests`                   | Yes  | List all employer requests   |
| GET    | `/employer-requests/{id}`              | Yes  | Get single request           |
| PATCH  | `/employer-requests/{id}/status`       | Yes  | Update request status        |
| DELETE | `/employer-requests/{id}`              | Yes  | Delete request               |

**Request types:** `internship`, `hiring`, `corporate_training`, `ai_workshop`

---

## Authentication

Praktix uses **Laravel Sanctum** token-based authentication.

### Login

```http
POST /api/auth/login
Content-Type: application/json

{
  "email": "admin@praktix.al",
  "password": "praktix2024"
}
```

**Response:**
```json
{
  "message": "Login successful.",
  "token": "1|abc123...",
  "admin": { "id": 1, "name": "Praktix Admin", "email": "admin@praktix.al" }
}
```

### Using the token

Include the token in all protected requests:

```http
Authorization: Bearer 1|abc123...
```

---

## Sample Requests

### Create a program
```http
POST /api/programs
Authorization: Bearer {token}
Content-Type: application/json

{
  "title": "iOS Development with Swift",
  "category": "Mobile Development",
  "description": "Build real iOS apps from scratch using Swift and SwiftUI.",
  "duration": "3 months",
  "price": 690,
  "image_url": "https://example.com/ios.jpg",
  "expert_id": 2,
  "certificate_included": true
}
```

### Student application
```http
POST /api/applications
Content-Type: application/json

{
  "full_name": "Anila Ramaj",
  "email": "anila.ramaj@gmail.com",
  "phone": "+355 69 111 2222",
  "program_id": 1,
  "cv_url": "https://drive.google.com/file/d/myCV"
}
```

### Employer request
```http
POST /api/employer-requests
Content-Type: application/json

{
  "company_name": "Digital Agency Tirana",
  "contact_person": "Sokol Mema",
  "email": "sokol@digitalagency.al",
  "request_type": "internship",
  "message": "Looking for 2 interns in web development for summer 2024."
}
```

### Update application status
```http
PATCH /api/applications/1/status
Authorization: Bearer {token}
Content-Type: application/json

{
  "status": "accepted",
  "notes": "Strong CV, technical assessment passed."
}
```

---

## Assumptions

1. **Single admin role** — all authenticated users are admins. Role-based permissions not implemented in this version.
2. **CV upload** — CVs are stored as URLs (Google Drive, Dropbox links). File upload not implemented to keep scope minimal.
3. **No email notifications** — submission confirmation is returned in the API response only.
4. **Public read access** — programs and experts are publicly viewable. Only write operations require auth.
5. **Soft deletes not used** — records are hard-deleted for simplicity.
6. **Pagination** — programs and applications return paginated results (10 and 15 per page respectively).
7. **`instructor` field** — mapped to the `expert` relationship (foreign key `expert_id`) rather than a plain text field, which is more scalable.

---

## Default Credentials (Seeded)

| Role  | Email               | Password      |
|-------|---------------------|---------------|
| Admin | admin@praktix.al    | praktix2024   |
