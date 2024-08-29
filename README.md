# Article Management System

This is a simple News Management application that allows users to create, edit, delete, and view news articles. The
application also includes a user authentication system with login and logout functionality.

## Features

- **Authentication:**
    - Login and logout functionality.

- **News Management:**
    - Create news articles.
    - Edit existing articles.
    - Delete articles.
    - View a list of all articles.

## Getting Started

### Prerequisites
- Docker and Docker Compose installed on your system. (I recommend using docker, but the application can be run without it)
- A web browser (latest version recommended).


### Installing

 ```bash
   cp .env.example .env
   ```

 ```bash
   docker-compose up --build -d
   ```

 ```bash
   docker-compose exec app composer install           
   ```

 ```bash
   docker compose exec app composer dump-autoload     
   ```

* Database and admin user creation

 ```bash
   docker compose exec app php scripts/console.php migrate
   ```

 ```bash
   docker compose exec app php scripts/console.php seed 
   ```

### Tests

```bash
   docker-compose exec app vendor/bin/phpunit
   ```

### Access the Application

Once the containers are up and running, you can access the application in your browser:

```
http://localhost
```

### Project Structure

Here is an overview of the project's directory structure:
```plaintext
article-management-system/
├── app/                         # Main application directory
│   ├── config/
│   │   ├── Config.php           # Application configuration file
│   │   └── services.php         # Service registration for the application
│   ├── database/
│   │   └── migrations/          # Database migration files
│   ├── framework/               # Application framework components
│   │   ├── Http/
│   │   │   └── Container.php    # Dependency Injection container for the application
│   └── public/                  # Publicly accessible files (served by the web server)
│   ├── routes/                  # Files defining application routes
│   ├── scripts/                 # Console scripts for database migration and seeding
│   └── src/                     # Main application logic
│       ├── Article/             # Article module
│       │   ├── Application/     # Application logic for articles
│       │   ├── Domain/          # Domain logic for articles
│       │   └── Infrastructure/  # Infrastructure for the article module
│       └── User/                # User module
│           ├── Application/     # Application logic for users
│           ├── Domain/          # Domain logic for users
│           └── Infrastructure/  # Infrastructure for the user module
├── templates/
│   ├── articles/                # Article templates
│   ├── user/                    # User templates
│   └── base.html.twig           # Main application template
├── vendor/                      # External PHP libraries installed via Composer
├── nginx/                       # Nginx server configuration
│   └── conf.d/
├── php/                         # PHP environment configuration
│   └── conf.d/
├── .env                         # Environment configuration file
├── .env.example                 # Example environment configuration file
├── .gitignore                   # Git ignore file
├── docker-compose.yaml          # Docker Compose configuration
└── README.md                    # Project documentation