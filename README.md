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

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/library-management-laravel.git
   ```

2. Navigate to the project directory:
   ```bash
   cd library-management-laravel
   ```

3. Install dependencies:
   ```bash
   composer install
   ```

4. Create a `.env` file and configure your database settings:
   ```bash
   cp .env.example .env
   ```

5. Generate an application key:
   ```bash
   php artisan key:generate
   ```

6. Run migrations:
   ```bash
   php artisan migrate
   ```

7. Start the development server:
   ```bash
   php artisan serve
   ```