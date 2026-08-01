# Task Management API

A RESTful API for a Task Management System built with Laravel 12. This project demonstrates clean architecture, repository pattern, service layer, API resources, form request validation, Sanctum authentication, soft deletes, and queue jobs.

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

- Laravel 12+
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
git clone https://github.com/m-elmohands/task-management-api.git
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

9. Access the API at `http://localhost:8000`

### Docker Setup (optional)

1. Install Docker [From Docker Site](https://docs.docker.com/get-started/get-docker/)

2. Build and start containers:
```bash
docker-compose up -d --build
```

3. Install dependencies inside the container:
```bash
docker-compose exec app composer install
```

4. Copy environment and generate key:
```bash
docker-compose exec app cp .env.example .env
docker-compose exec app php artisan key:generate
```

5. Run migrations and seeders:
```bash
docker-compose exec app php artisan migrate --seed
```

6. Access the API at `http://localhost:8080`

---

## Swagger / OpenAPI Documentation

This project includes interactive API documentation powered by **Swagger UI** and **OpenAPI 3.0**.

### Swagger Configuration

The Swagger documentation is configured via the `config/l5-swagger.php` file. Key settings:

| Setting | Value | Description |
|---------|-------|-------------|
| `api` | `api/documentation` | URL path for Swagger UI |
| `docs` | `api/docs` | URL path for raw JSON spec |
| `annotations` | `app/` | Scanned for OpenAPI annotations |

### Generating the Documentation

If you modify API annotations or the OpenAPI spec, regenerate the docs:

```bash
php artisan l5-swagger:generate
```

### OpenAPI Specification File

The raw OpenAPI 3.0 YAML specification is available at:

```
http://localhost:8000/api/docs
```

Or import the `swagger.yaml` file directly into:
- [Swagger Editor](https://editor.swagger.io/)
- Postman (Import > File)
- Insomnia
- Any OpenAPI-compatible tool

### Authenticating in Swagger UI

1. Click the **Authorize** button (🔒) at the top right of the Swagger UI
2. Enter your token in the format: `Bearer YOUR_TOKEN_HERE`
3. Click **Authorize** and close the modal
4. All protected endpoints will now include the token in requests

### Swagger Annotations (Optional)

If you prefer annotation-based docs over the YAML file, install L5-Swagger and add PHPDoc annotations to your controllers:

```bash
composer require darkaonline/l5-swagger
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"
```

Example annotation in a controller:

```php
/**
 * @OA\Get(
 *     path="/api/projects",
 *     summary="List all projects",
 *     tags={"Projects"},
 *     security={{"bearerAuth": {}}},
 *     @OA\Parameter(name="status", in="query", @OA\Schema(type="string", enum={"active", "completed", "archived"})),
 *     @OA\Response(response=200, description="List of projects", @OA\JsonContent(ref="#/components/schemas/PaginatedProjects"))
 * )
 */
public function index(Request $request): JsonResponse
```

### Access the Documentation

Once the application is running, open your browser and navigate to:

```
http://localhost:8000/api/documentation
```

You will see an interactive Swagger UI where you can:
- Browse all available endpoints
- View request/response schemas with examples
- Test endpoints directly from the browser
- Authenticate with your Bearer token to access protected routes
---

```
app/
├── Config/
│   ├── CustomApiRequest.php
│   ├── helpers.php
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
|   |   ├── Auth/
│   │   |   ├── LoginRequest.php
│   │   |   └── RegisterRequest.php
|   |   ├── Projects/
│   │   |   ├── StoreProjectRequest.php
│   │   |   └── UpdateProjectRequest.php
|   |   └── Tasks/
│   │       ├── StoreTaskRequest.php
│   │       └── UpdateTaskRequest.php
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
- **Password:** `12345678`

## Postman Collection

Import `Task_Management_API_Postman_Collection.json` into Postman. Set the `base_url` environment variable to your API URL.

## License

This project is for assessment purposes `m-elmohands`.
