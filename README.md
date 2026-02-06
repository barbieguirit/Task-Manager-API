# Task Manager API

A RESTful API for managing tasks built with Symfony and API Platform.

## Prerequisites

- Docker & Docker Compose
- PHP 8.2+ (if running locally without Docker)
- Composer

## Project Setup

### 1. Clone and Install Dependencies

```bash
cd task-manager-api
composer install
```

### 2. Configure Environment

Create a `.env.local` file (or use the existing `.env`):

```
DATABASE_URL="mysql://task_manager_user:task_manager_password@mysql:3306/task_manager_api"
```

### 3. Start Docker Containers

```bash
docker-compose up -d
```

This will start:
- **PHP App**: http://localhost:8007
- **MySQL Database**: localhost:3311

### 4. Run Database Migrations

```bash
docker-compose exec app php bin/console doctrine:migrations:migrate
```

Or if running locally:

```bash
php bin/console doctrine:migrations:migrate
```

### 5. Verify Installation

Visit the endpoints:
- API Documentation: http://localhost:8007/api
- Get All Tasks: http://localhost:8007/api/tasks

## API Endpoints

### Tasks Resource

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/api/tasks` | Get all tasks |
| GET | `/api/tasks/{id}` | Get a specific task |
| POST | `/api/tasks` | Create a new task |
| PUT | `/api/tasks/{id}` | Update a task (all fields) |
| PATCH | `/api/tasks/{id}` | Partially update a task |
| DELETE | `/api/tasks/{id}` | Delete a task |

### Example Requests

**Create a Task (POST)**
```bash
curl -X POST http://localhost:8007/api/tasks \
  -H "Content-Type: application/json" \
  -d '{"title": "Buy groceries", "description": "Milk, eggs, bread"}'
```

**Get All Tasks (GET)**
```bash
curl http://localhost:8007/api/tasks
```

**Mark Task as Completed (PATCH)**
```bash
curl -X PATCH http://localhost:8007/api/tasks/1 \
  -H "Content-Type: application/json" \
  -d '{"isCompleted": true}'
```

**Update Task (PUT)**
```bash
curl -X PUT http://localhost:8007/api/tasks/1 \
  -H "Content-Type: application/json" \
  -d '{"title": "Buy groceries", "description": "Updated list", "isCompleted": false}'
```

**Delete Task (DELETE)**
```bash
curl -X DELETE http://localhost:8007/api/tasks/1
```

## Task Entity

Tasks have the following properties:
- `id` (integer): Unique identifier
- `title` (string): Task title
- `description` (string, nullable): Task description
- `isCompleted` (boolean): Completion status (default: false)
- `createdAt` (datetime): Creation timestamp (auto-set)

## Database Structure

Database Name: `task_manager_api`

**Task Table:**
```sql
CREATE TABLE task (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description LONGTEXT,
  is_completed TINYINT NOT NULL DEFAULT 0,
  created_at DATETIME NOT NULL
)
```

## Technology Stack

- **Framework**: Symfony 6.x
- **API Platform**: API-Platform 3.x
- **ORM**: Doctrine ORM
- **Database**: MySQL 8.0
- **Container**: Docker

## Development

### Stop Containers

```bash
docker-compose down
```

### View Logs

```bash
docker-compose logs -f app
```

### Access Database CLI

```bash
docker-compose exec mysql mysql -u task_manager_user -p task_manager_api
```

## Notes

- API Platform automatically exposes the Task entity as REST resources
- Default API documentation is available at `/api`
- All responses are JSON serialized with appropriate HTTP status codes
- Date times are stored as immutable in the database