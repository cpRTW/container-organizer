# Laravel Container Organizer

## 📌 Overview

This project solves the container organization problem using a matrix-based algorithm.
It determines whether containers can be rearranged so that each container holds only one type of ball using swap operations.

---

## ⚙️ Setup

```bash
git clone <https://github.com/cpRTW/container-organizer>
cd container-organizer
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

---

## 📡 API

### Check Organization

POST `/api/organization/check`

#### Request

```json
{
  "matrix": [
    [1,3,1],
    [2,1,2],
    [0,2,1]
  ]
}
```

#### Response

```json
{
  "possible": true,
  "rowSums": [3,5,5],
  "colSums": [3,5,5]
}
```

---

## 🧠 Logic

* Calculate row sums (container capacities)
* Calculate column sums (ball type totals)
* Sort both arrays
* Compare them

**Condition:**
If `sort(rowSums) == sort(colSums)` → Possible
Else → Not Possible

---

## 🗄️ Database Tables

* containers
* ball_types
* balls
* swap_operations
* organization_requests

---

## 🧪 Testing

```bash
php artisan test
```

---

## 🚀 Features

* Service-based architecture
* Input validation
* REST API implementation
* Unit & Feature tests

---

## 👨‍💻 Author

Chandra Pratap
