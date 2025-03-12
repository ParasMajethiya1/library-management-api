# Library Management API - Laravel 10

This is a simple Library Management API built using Laravel 10. The API allows users to register, login, and manage books. It includes functionalities for adding, updating, deleting, borrowing, and returning books.

## Features

- User Registration and Login
- Book Management:
  - Add a new book
  - Update an existing book
  - Delete a book
  - Borrow a book
  - Return a borrowed book
- Authentication using JWT (JSON Web Tokens)

## API Endpoints

### Authentication

- **Register a new user**
  - **URL:** `/api/register`
  - **Method:** `POST`
  - **Body:**
    ```json
    {
      "name": "Paras",
      "email": "parasmajethiya2021@gmail.com",
      "password": "DRftgyhu12#",
      "password_confirmation": "DRftgyhu12#"
    }
    ```

- **Login**
  - **URL:** `/api/login`
  - **Method:** `POST`
  - **Body:**
    ```json
    {
      "email": "parasmajethiya1@gmail.com",
      "password": "password123#"
    }
    ```

- **Logout**
  - **URL:** `/api/logout`
  - **Method:** `POST`
  - **Headers:**
    ```json
    {
      "Authorization": "Bearer <token>"
    }
    ```

### Book Management

- **Get all books**
  - **URL:** `/api/books`
  - **Method:** `GET`
  - **Headers:**
    ```json
    {
      "Authorization": "Bearer <token>"
    }
    ```

- **Add a new book**
  - **URL:** `/api/books`
  - **Method:** `POST`
  - **Headers:**
    ```json
    {
      "Authorization": "Bearer <token>"
    }
    ```
  - **Body:**
    ```json
    {
      "title": "Paras Book",
      "author": "Paras",
      "description": "PHP"
    }
    ```

- **Get a specific book**
  - **URL:** `/api/books/{id}`
  - **Method:** `GET`
  - **Headers:**
    ```json
    {
      "Authorization": "Bearer <token>"
    }
    ```

- **Update a book**
  - **URL:** `/api/books/{id}`
  - **Method:** `PUT`
  - **Headers:**
    ```json
    {
      "Authorization": "Bearer <token>",
      "Content-Type": "application/json"
    }
    ```
  - **Body:**
    ```json
    {
      "title": "Updated Title",
      "author": "Updated Author",
      "description": "Updated Description"
    }
    ```

- **Delete a book**
  - **URL:** `/api/books/{id}`
  - **Method:** `DELETE`
  - **Headers:**
    ```json
    {
      "Authorization": "Bearer <token>"
    }
    ```

- **Borrow a book**
  - **URL:** `/api/books/{id}/borrow`
  - **Method:** `POST`
  - **Headers:**
    ```json
    {
      "Authorization": "Bearer <token>"
    }
    ```

- **Return a borrowed book**
  - **URL:** `/api/books/{id}/return`
  - **Method:** `POST`
  - **Headers:**
    ```json
    {
      "Authorization": "Bearer <token>"
    }
    ```

## Installation

# Library Management API - Installation Guide

## Prerequisites
Before proceeding with the installation, ensure that you have the following requirements installed on your system:
- PHP (>=8.0)
- Composer
- MySQL
- Laravel
- Git

## Installation Steps

### 1. Clone the Repository
Run the following command to clone the project:
```bash
git clone https://github.com/ParasMajethiya1/library-management-api.git
```

### 2. Set Up Environment Configuration
Copy the `.env.testing` file to `.env` and update the database configuration:
```bash
cp .env.testing .env
```
Modify the `.env` file with your database credentials:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=library_management
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Run Database Migrations and Seed Data
Run the following command to create tables and seed initial data:
```bash
php artisan migrate:fresh --seed
```

### 4. Install Laravel Passport
To enable API authentication, install Laravel Passport:
```bash
php artisan passport:install
```

### 5. Run Tests in Testing Environment
Run the migration and install Passport for the testing environment:
```bash
php artisan migrate:fresh --env=testing --seed
php artisan passport:install --env=testing
```

### 6. Run Automated Tests
To ensure everything is set up correctly, execute the test suite:
```bash
php artisan test
```

## Notes
- Ensure your MySQL service is running before running the migrations.
- If you encounter any issues, check the Laravel logs in `storage/logs/`.
- Use `php artisan serve` to start the development server.

# API Documentation

This document provides a detailed guide on how to interact with the API for user registration, login, logout, and book management. The API endpoints are designed to handle various operations such as creating, reading, updating, and deleting books, as well as borrowing and returning books.

## Base URL

All API requests should be made to the base URL:

```
http://127.0.0.1:8000/api
```

## Authentication

Most endpoints require authentication. After logging in, you will receive a Bearer token that you must include in the `Authorization` header of subsequent requests.

### Register a New User

**Endpoint:** `/register`

**Method:** `POST`

**Headers:**
- `Accept: application/json`

**Form Data:**
- `name` (string): User's full name.
- `email` (string): User's email address.
- `password` (string): User's password.
- `password_confirmation` (string): Confirmation of the user's password.

**Example Request:**

```bash
curl --location 'http://127.0.0.1:8000/api/register' \
--header 'Accept: application/json' \
--form 'name="Paras"' \
--form 'email="parasmajethiya2021@gmail.com"' \
--form 'password="DRftgyhu12\#"' \
--form 'password_confirmation="DRftgyhu12\#"'
```

### Login

**Endpoint:** `/login`

**Method:** `POST`

**Headers:**
- `Accept: application/json`

**Form Data:**
- `email` (string): User's email address.
- `password` (string): User's password.

**Example Request:**

```bash
curl --location 'http://127.0.0.1:8000/api/login' \
--header 'Accept: application/json' \
--form 'email="parasmajethiya2021@gmail.com"' \
--form 'password="DRftgyhu12\#"'
```

### Logout

**Endpoint:** `/logout`

**Method:** `POST`

**Headers:**
- `Accept: application/json`
- `Authorization: Bearer <token>`

**Example Request:**

```bash
curl --location --request POST 'http://127.0.0.1:8000/api/logout' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...'
```

## Book Management

### Get All Books

**Endpoint:** `/books`

**Method:** `GET`

**Headers:**
- `Authorization: Bearer <token>`

**Example Request:**

```bash
curl --location 'http://127.0.0.1:8000/api/books' \
--header 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...'
```

### Create a New Book

**Endpoint:** `/books`

**Method:** `POST`

**Headers:**
- `Authorization: Bearer <token>`

**Form Data:**
- `title` (string): Title of the book.
- `author` (string): Author of the book.
- `description` (string): Description of the book.

**Example Request:**

```bash
curl --location 'http://127.0.0.1:8000/api/books' \
--header 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...' \
--form 'title="Paras Book"' \
--form 'author="Paras"' \
--form 'description="PHP"'
```

### Get a Specific Book

**Endpoint:** `/books/{id}`

**Method:** `GET`

**Headers:**
- `Authorization: Bearer <token>`

**Example Request:**

```bash
curl --location 'http://127.0.0.1:8000/api/books/101' \
--header 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...'
```

### Update a Book

**Endpoint:** `/books/{id}`

**Method:** `PUT`

**Headers:**
- `Content-Type: application/json`
- `Authorization: Bearer <token>`

**Body Data:**
- `title` (string): Updated title of the book.
- `author` (string): Updated author of the book.
- `description` (string): Updated description of the book.

**Example Request:**

```bash
curl --location --request PUT 'http://127.0.0.1:8000/api/books/100' \
--header 'Content-Type: application/json' \
--header 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...' \
--data '{
    "title": "Updated Title",
    "author": "Updated Author",
    "description": "Updated Description"
}'
```

### Delete a Book

**Endpoint:** `/books/{id}`

**Method:** `DELETE`

**Headers:**
- `Authorization: Bearer <token>`

**Example Request:**

```bash
curl --location --request DELETE 'http://127.0.0.1:8000/api/books/102' \
--header 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...'
```

### Borrow a Book

**Endpoint:** `/books/{id}/borrow`

**Method:** `POST`

**Headers:**
- `Authorization: Bearer <token>`

**Example Request:**

```bash
curl --location --request POST 'http://127.0.0.1:8000/api/books/100/borrow' \
--header 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...'
```

### Return a Book

**Endpoint:** `/books/{id}/return`

**Method:** `POST`

**Headers:**
- `Authorization: Bearer <token>`

**Example Request:**

```bash
curl --location --request POST 'http://127.0.0.1:8000/api/books/100/return' \
--header 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9...'
```

## Notes

- Replace `<token>` with the actual Bearer token received after logging in.
- Ensure that the `Authorization` header is included in all requests that require authentication.
- The `id` in the URL should be replaced with the actual ID of the book you are interacting with.

## For postman collection check project directory and follow above steps