# Task Management API

A RESTful API for a Task Management System built with Laravel 11. This project demonstrates clean architecture, repository pattern, service layer, API resources, form request validation, Sanctum authentication, soft deletes, and queue jobs.

## Features

- **Authentication**: Register, Login, Logout using Laravel Sanctum
- **Projects Module**: Full CRUD with status tracking (Active, Completed, Archived)
- **Tasks Module**: Full CRUD with priority levels, status tracking, filtering, and search
- **Dashboard**: Aggregated statistics endpoint
- **Bonus Features**:
  - Repository Pattern
  - Service Layer
  - Queue Jobs for overdue task notifications
  - Feature Tests
  - Docker Support
  - Postman Collection

## Tech Stack

- Laravel 11+
- PHP 8.2+
- MySQL 8.0
- Redis (for queues)
- Docker & Docker Compose

## Requirements

- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Redis (optional, for queues)
- Docker (optional)

## Installation

### Standard Setup

1. Clone the repository:
```bash
git clone <repository-url>
cd task-management-api
```

2. Install dependencies:
```bash
composer install
```

3. Copy environment file:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Configure your database in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_management
DB_USERNAME=root
DB_PASSWORD=your_password
```

6. Run migrations:
```bash
php artisan migrate
```

7. Run seeders:
```bash
php artisan db:seed
```

8. Start the development server:
```bash
php artisan serve
```

### Docker Setup

1. Build and start containers:
```bash
docker-compose up -d --build
```

2. Install dependencies inside the container:
```bash
docker-compose exec app composer install
```

3. Copy environment and generate key:
```bash
docker-compose exec app cp .env.example .env
docker-compose exec app php artisan key:generate
```

4. Run migrations and seeders:
```bash
docker-compose exec app php artisan migrate --seed
```

5. Access the API at `http://localhost:8000`

## API Documentation

### Authentication Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/register` | Register a new user |
| POST | `/api/login` | Login and get token |
| POST | `/api/logout` | Logout (requires auth) |

### Project Endpoints (Auth Required)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/projects` | List all projects (paginated) |
| POST | `/api/projects` | Create a new project |
| GET | `/api/projects/{id}` | View a specific project |
| PUT | `/api/projects/{id}` | Update a project |
| DELETE | `/api/projects/{id}` | Delete a project (soft delete) |

**Query Parameters for List:**
- `status` - Filter by status: `active`, `completed`, `archived`
- `page` - Pagination page number

### Task Endpoints (Auth Required)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/projects/{project}/tasks` | List tasks for a project |
| POST | `/api/projects/{project}/tasks` | Create a task |
| GET | `/api/projects/{project}/tasks/{task}` | View a task |
| PUT | `/api/projects/{project}/tasks/{task}` | Update a task |
| DELETE | `/api/projects/{project}/tasks/{task}` | Delete a task (soft delete) |

**Query Parameters for List:**
- `status` - Filter by status: `todo`, `in_progress`, `done`
- `priority` - Filter by priority: `low`, `medium`, `high`
- `search` - Search by title (partial match)
- `page` - Pagination page number

### Dashboard Endpoint (Auth Required)

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/dashboard` | Get dashboard statistics |

**Response:**
```json
{
  "data": {
    "total_projects": 10,
    "active_projects": 7,
    "total_tasks": 50,
    "completed_tasks": 20,
    "pending_tasks": 25,
    "overdue_tasks": 5
  }
}
```

## Project Structure

```
app/
├── Enums/
│   ├── ProjectStatus.php
│   ├── TaskPriority.php
│   └── TaskStatus.php
├── Http/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── ProjectController.php
│   │   └── TaskController.php
│   ├── Requests/
│   │   ├── LoginRequest.php
│   │   ├── RegisterRequest.php
│   │   ├── StoreProjectRequest.php
│   │   ├── UpdateProjectRequest.php
│   │   ├── StoreTaskRequest.php
│   │   └── UpdateTaskRequest.php
│   └── Resources/
│       ├── ProjectResource.php
│       ├── TaskResource.php
│       └── UserResource.php
├── Jobs/
│   └── SendOverdueTaskNotification.php
├── Models/
│   ├── Project.php
│   ├── Task.php
│   └── User.php
├── Repositories/
│   ├── Contracts/
│   │   ├── ProjectRepositoryInterface.php
│   │   └── TaskRepositoryInterface.php
│   ├── ProjectRepository.php
│   └── TaskRepository.php
└── Services/
    ├── ProjectService.php
    └── TaskService.php
```

## Running Tests

```bash
php artisan test
```

## Running Queue Worker

For overdue task notifications:

```bash
php artisan queue:work
```

## Scheduling Overdue Task Checks

Add to your server crontab:

```bash
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

Or run manually:

```bash
php artisan tasks:check-overdue
```

## Default Test Credentials

After seeding:
- **Email:** `test@example.com`
- **Password:** `password`

## Postman Collection

Import `Task_Management_API_Postman_Collection.json` into Postman. Set the `base_url` environment variable to your API URL.

## License

This project is for assessment purposes.
