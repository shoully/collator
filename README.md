# ShareHub

A Laravel-based collaboration hub for sharing projects, tasks, documents, chats, meetings, and mentoring sessions. This README helps you set up, run, and contribute to the project.

## Features
- Projects and Tasks management
- Document storage and sharing
- Real-time or threaded Chat (implementation-dependent)
- Meetings scheduler/tracker
- Mentoring module
- User authentication and authorization
- API routes plus web UI (Vue + Inertia stack typical for Laravel projects)

## Tech Stack
- PHP (Laravel)
- MySQL or MariaDB
- Node.js (Vite/Mix build tooling)
- Vue.js (resources/js)
- Tailwind CSS (if enabled) / Bootstrap assets available in `public/`

## Prerequisites
- PHP 8.1+
- Composer
- Node.js 18+ and npm
- MySQL/MariaDB

## Quick Start
1. Clone the repository
   ```bash
   git clone <your-repo-url> && cd ShareHub/code
   ```
2. Install PHP dependencies
   ```bash
   composer install
   ```
3. Copy environment file
   ```bash
   cp .env.example .env
   ```
4. Generate app key
   ```bash
   php artisan key:generate
   ```
5. Configure database in `.env` (see Env Variables below)
6. Run migrations (and seeders if desired)
   ```bash
   php artisan migrate
   php artisan db:seed   # optional
   ```
7. Install JS dependencies and build assets
   ```bash
   npm install
   npm run dev    # or: npm run build
   ```
8. Serve the application
   ```bash
   php artisan serve
   ```
   App will be available at `http://127.0.0.1:8000`.

## Environment Variables
Open `code/.env` and confirm these values. IMPORTANT: Check database names and passwords and stuff before running migrations.

- `APP_NAME=ShareHub`
- `APP_ENV=local`
- `APP_KEY=base64:...` (set by `php artisan key:generate`)
- `APP_DEBUG=true`
- `APP_URL=http://localhost`

Database (update to match your local DB):
- `DB_CONNECTION=mysql`
- `DB_HOST=127.0.0.1`
- `DB_PORT=3306`
- `DB_DATABASE=sharehub`    ← Make sure this database exists
- `DB_USERNAME=your_username`  ← Check this
- `DB_PASSWORD=your_password`  ← And this

Optional mail/queue/logging services are configured in `code/config/` and `code/.env`.

## Project Structure (key paths)
- `code/app/Models/` — Core models like `Project`, `Task`, `Document`, `Chat`, `Meeting`, `Mentoring`, `User`
- `code/app/Http/Controllers/` — Application controllers
- `code/resources/js/` — Frontend (Vue components)
- `code/resources/views/` — Blade templates
- `code/routes/` — Route definitions (`web.php`, `api.php`)
- `code/database/migrations/` — Schema migrations
- `code/public/` — Public assets

## Running Tests
From `code/`:
```bash
php artisan test
```

## Common Commands
- Clear caches: `php artisan optimize:clear`
- Run migrations fresh with seed: `php artisan migrate:fresh --seed`
- Build assets for production: `npm run build`

## Troubleshooting
- If migrations fail, re-check your `.env` database settings (names, username, password) and ensure the database exists.
- If assets don’t load, ensure `npm install` completed and re-run `npm run dev`.
- See logs in `code/storage/logs/laravel.log`.

## License
This project is licensed under the terms of the LICENSE file included in the repository.

# Collator
Mentorship and Knowledge Exchange app
<br>
pages and what not ~

action/logic<br>
+meetings 
*requests from the mentee.
*user register type to get data from the database.
+other
*number of task from activites related to this area

	
Table | Developments |
--- | --- |
Id | ` id` |
Title | `title` |
Completed_Activities | `Completed activities` |
Total_Activities | `total activities` |


Table | Activities |
--- | --- |
Title | ` title` |
Description | `description` |
Development_id | `development id` |
Priorities | `priorities` |
Status | `status (On track - on hold - done - ready - off trach - blocked)` |

Table | Meeting_Requests |
--- | --- |
Date | ` date` |
Time | `time` |
Title | `title` |
Url | `url` |
	
Table | Meeting_Request_Feedbacks |
--- | --- |
Id | ` table id` |
Text | `feed back` |


Table | user |
--- | --- |
Name | ` Name of the mentor` |
Email | `Email of the mentor` |
Phone | `Phone of the mentor` |
Bio | `Bio of the mentor` |

Table | Mentee |
--- | --- |
Name | ` Name of the mentee` |
Email | `Email of the mentee` |
Phone | `Phone of the mentee` |
Bio | `Bio of the mentee` |

Table | Project |
--- | --- |
Title| ` Name of the mentee` |
desc
file
Owner | `Email of the mentee` |
ProjectDate | `Phone of the mentee` |


Table | Chat |
--- | --- |
message| ` Name of the mentee` |
Owner | `Email of the mentee` |
Date_Timestamp  | `Phone of the mentee` |


```
> Laravel + Laravel Octane + VueJs + SQLite
```