<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Library Management API

Lightweight RESTful API for managing authors, books, members and borrowings — built with Laravel 12.
This repository is a sample library management backend (API-only) with models and endpoints for Authors, Books, Members and Borrowings. It includes request validation, API resources, factories and migrations so you can set it up locally for development

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

## 🧾 Features (implemented & planned)

Implemented
- Author and Book resource CRUD (controllers, requests, resources, factories and migrations)
- Paginated list endpoints using Resource Collections
- Author-Book relationship with books count returned by `AuthorResource`
- Book convenience methods: availability check, borrow/return helpers
- Database factories and seeders to create test/demo records
- Sanctum setup available for token-based authentication

Planned / present in code (models & migrations exist)
- Models & database structure for Members and Borrowings (see `app/Models`) — these are present and ready for API controllers
- Borrowing lifecycle helpers (overdue checks, status management)

If you need a complete API for Members and Borrowings created (endpoints, resources, routes), I can add these controllers + validation to match the style used for Authors and Books.

---

## 📘 Members & Borrowings (models included)

The project already includes the `Member` and `Borrowing` models and migrations. These capture typical library flows:

- Member: name, email, phone, address, membership_date, status
- Borrowing: book_id, member_id, borrowed_date, due_date, returned_date, status

Example JSON to create a member (if a `POST /api/members` route is added):

```json
POST /api/members
{
	"name": "Jane Doe",
	"email": "jane@example.com",
	"phone": "+1-555-1234",
	"address": "123 Library Lane",
	"membership_date": "2024-01-12",
	"status": "active"
}
```

Example JSON to create a borrowing record (if a `POST /api/borrowings` route is added):

```json
POST /api/borrowings
{
	"book_id": 5,
	"member_id": 2,
	"borrowed_date": "2025-11-28",
	"due_date": "2025-12-12",
	"status": "borrowed"
}
```

These endpoints are not wired in `routes/api.php` by default, but the building blocks (models, migrations, and factory definitions) are present so adding resource controllers is straightforward.

---

## 🪟 Windows (WAMP) dev tips

If you're running this on Windows with WAMP or similar, here are commands and tips that work in PowerShell:

1. Ensure your command prompt runs with PHP in PATH (WAMP's php folder) or use the full path.

2. Copy `.env` and create sqlite file (quick local set up):

```powershell
copy .env.example .env
php artisan key:generate
New-Item -ItemType File -Path database\database.sqlite -Force
```

3. Run migrations and seeders

```powershell
php artisan migrate --seed
php artisan serve
```

4. Generate a token for quick API calls (Tinker example):

```powershell
php artisan tinker
>>> $user = \App\Models\User::factory()->create([ 'email' => 'dev@example.com' ]);
>>> $user->createToken('dev-token')->plainTextToken;
```

Then use that token as a Bearer token in requests.


## 🧩 Contributing

Contributions are welcome — open an issue or create a pull request with a clear explanation of changes. If you add features, please include tests.

---

## 📜 License

MIT — see the main repository license.

---
 
