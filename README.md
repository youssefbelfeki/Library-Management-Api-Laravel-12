<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Library Management API

Lightweight RESTful API for managing authors, books, members and borrowings — built with Laravel.

This repository is a sample library management backend (API-only) with models and endpoints for Authors, Books, Members and Borrowings. It includes request validation, API resources, factories and migrations so you can set it up locally for development, testing, or prototypes.

---

## 🔧 Key features

- RESTful API for Authors and Books (resource controllers and JSON resources)
- Models: Author, Book, Member, Borrowing, User
- Relationships and convenience methods (e.g. book availability and borrow/return helpers)
- Request validation and resources for consistent JSON responses
- Uses Laravel Sanctum for API authentication (token-based)

---

## ⚙️ Requirements

- PHP 8.2+
- Composer
- MySQL / SQLite / other database supported by Laravel
- Node.js + npm (optional for any asset building)

Works well on Windows (e.g., WAMP) or typical Linux/macOS dev environments.

---

## 🚀 Quick start (local)

1. Clone the repository

```bash
git clone <repository-url> library-management-api
cd library-management-api
```


## 🔎 API overview

This project exposes resource routes in `routes/api.php` for Authors and Books. The default routes are:

| Method | Endpoint | Description |
|---|---:|---|
| GET | /api/authors | Get paginated authors (includes books count if loaded) |
| POST | /api/authors | Create an author |
| GET | /api/authors/{id} | Get a single author |
| PUT/PATCH | /api/authors/{id} | Update an author |
| DELETE | /api/authors/{id} | Remove an author |

| GET | /api/books | Get paginated books (author relation loaded) |
| POST | /api/books | Create a book |
| GET | /api/books/{id} | Get a single book (author loaded) |
| PUT/PATCH | /api/books/{id} | Update a book |
| DELETE | /api/books/{id} | Remove a book |

### Request & response examples

Create a book (JSON payload example):

```json
POST /api/books
{
	"title": "Dune",
	"isbn": "9780441013593",
	"description": "Science fiction novel",
	"author_id": 1,
	"genre": "Sci-Fi",
	"published_at": "1965-08-01",
	"total_copies": 5,
	"available_copies": 5,
	"price": 19.99,
	"cover_image": null,
	"status": "available"
}
```

Example response (BookResource shape):

```json
{
	"title": "Dune",
	"isbn": "9780441013593",
	"description": "Science fiction novel",
	"genre": "Sci-Fi",
	"published_at": "1965-08-01",
	"total_copies": 5,
	"available_copies": 5,
	"price": 19.99,
	"cover_image": null,
	"status": "available",
	"is_available": true,
	"author_id": {
		"name": "FRANK HERBERT",
		"bio": "...",
		"nationality": "american",
		"books": 3
	}
}
```

Authors use `AuthorResource` and return fields including `name`, `bio`, `nationality` and a `books` count when relation is loaded.

---

## 🧪 Tests

Run automated tests using PHPUnit/Laravel's test runner:

```bash
composer test
php artisan test
```

---

## 🧩 Contributing

Contributions are welcome — open an issue or create a pull request with a clear explanation of changes. If you add features, please include tests.

---

## 📜 License

MIT — see the main repository license.

---
 
