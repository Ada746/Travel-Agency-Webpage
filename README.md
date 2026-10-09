# 🌍 Travel Website

A small travel-booking web app built with **PHP**, **MySQL/MariaDB** (managed through **phpMyAdmin**) and plain **HTML/CSS**.
Browse a catalog of trips, filter by category, pick your dates, add trips to a session-based cart and simulate payment.

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-MariaDB-4479A1?logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/license-MIT-green)

> <img width="1920" height="989" alt="Screenshot 2026-10-09 204238" src="https://github.com/user-attachments/assets/db3713de-3a65-4bfe-9aa7-865c8e119f09" />
<img width="1920" height="986" alt="Screenshot 2026-10-09 204246" src="https://github.com/user-attachments/assets/37a5611c-7d07-4ced-80f3-0d25c5d89a47" />
<img width="1920" height="868" alt="Screenshot 2026-10-09 204259" src="https://github.com/user-attachments/assets/5c18f44a-059e-4be5-96fd-20b7d1b47171" />

---

## ✨ Features

- **Trip catalog** loaded from the database, with a category filter
- **Detail page** with image gallery, transport, daily price and description
- **Reservation form** with server-side validation (required dates, no past departure, return not before departure)
- **Session cart**: price per trip = number of days × daily price (minimum 1 day), running cart total, live item counter in the header
- **Simulated checkout** that clears the cart and shows a confirmation
- **Safe database access**: prepared statements for every query that takes user input
- **Output escaping** with `htmlspecialchars()` in the views

## 🧱 Tech stack

| Layer      | Technology                                  |
|------------|---------------------------------------------|
| Backend    | PHP (procedural, `mysqli`), sessions        |
| Database   | MySQL / MariaDB, administered via phpMyAdmin |
| Frontend   | HTML5, CSS3 (grid + flexbox, no framework)  |

## 🗂 Project structure

```
travel-website/
├── index.php            # Front controller: routes ?action=... to the right logic + view
├── config.example.php   # DB settings template (copy to config.php)
├── style.css
├── models/
│   ├── travel.php       # DB queries: getTravels, getTravelById, getCategories
│   └── cart.php         # Session cart: addToCart, allTravelsInCart, getCartTotal, clearCart
├── views/
│   ├── header.php       # Shared layout top + nav (with cart counter)
│   ├── footer.php       # Shared layout bottom
│   ├── list.php         # Catalog + category filter
│   ├── detail.php       # Trip page + reservation form
│   └── cart.php         # Cart table + payment simulation

```

The app follows a light **MVC** pattern: `index.php` is the controller, `models/` talks to the database and session, `views/` only renders HTML.

```

| Route                     | Method | What it does                                             |
|---------------------------|--------|----------------------------------------------------------|
| `index.php`               | GET    | Catalog (optional `&category=...`)                       |
| `?action=detail&id=N`     | GET    | Trip details + booking form                              |
| `?action=add_to_cart`     | POST   | Validates dates, adds the trip to the cart, redirects    |
| `?action=cart`            | GET    | Shows the cart and total                                 |
| `?action=pay`             | GET    | Simulated payment, empties the cart                      |

## 🗄 Database: from phpMyAdmin to the web page

The trip data lives in one table, `maria_travel`. Here is the full path from data to page.

### 1. Create the database in phpMyAdmin
1. Open phpMyAdmin → **New** → create a database (e.g. `travel`) with collation `utf8mb4_general_ci`.
2. Create a user with privileges on that database (**User accounts → Add user account**).

### 2. Create the table and load the data
- Go to the **Import** tab and import `database/schema.sql`, then `database/sample_data.sql`
  *(or paste them into the **SQL** tab)*.
- To use your own data: **Export** your table from phpMyAdmin as **SQL** (to recreate it) or as **JSON** (to share/inspect it). `database/sample_data.json` shows the JSON shape: one object per row, one key per column.

| Column        | Type          | Notes                                              |
|---------------|---------------|----------------------------------------------------|
| `id`          | INT, PK, AI   | Used in `?action=detail&id=N`                      |
| `title`       | VARCHAR       |                                                    |
| `destination` | VARCHAR       |                                                    |
| `category`    | VARCHAR       | Drives the filter dropdown (`SELECT DISTINCT`)     |
| `transport`   | VARCHAR       |                                                    |
| `daily_price` | DECIMAL       | Price in € per day                                 |
| `description` | TEXT          |                                                    |
| `images`      | TEXT          | **Comma-separated** file names, e.g. `a.jpg,b.jpg` |

### 3. How the rows become array/JSON-like data in PHP
`models/travel.php` runs the query and fetches each row with `fetch_assoc()`, which turns a row into an associative array, the PHP equivalent of one JSON object:

```php
$travels[] = $row;   // [ 'id' => 1, 'title' => 'Weekend in Rome', ... ]
```

The `images` column is split into a list in the controller:

```php
$images = explode(",", $travel['images']);   // ['rome1.jpg', 'rome2.jpg']
```

The views then loop over these arrays (`foreach ($travels as $t)`) and print the HTML cards, gallery and cart rows. The cart uses the same idea: each cart item is an associative array stored in `$_SESSION['cart']`.

> Want a real JSON output? Add `echo json_encode($travels);` in a small endpoint. This is a good first step toward an API (see roadmap).

## 🚀 Getting started

**Requirements:** PHP 8+ with `mysqli`, MySQL/MariaDB, a web server (Apache via XAMPP/WAMP/MAMP, or PHP's built-in server).

```bash
git clone https://github.com/<your-username>/travel-website.git
cd travel-website

# 1. configure the database connection
cp config.example.php config.php
#    then edit config.php (or set DB_HOST, DB_NAME, DB_USER, DB_PASS env vars)

# 2. import database/schema.sql and database/sample_data.sql via phpMyAdmin
#    (or: mysql -u user -p travel < database/schema.sql)

# 3. add your trip photos to images/ (names must match the `images` column)

# 4. run it
php -S localhost:8000
```

Open <http://localhost:8000>.

## 🧭 Known limitations & roadmap

- [ ] Payment is triggered by a **GET link**; switch to a POST form with a CSRF token
- [ ] No way to remove a single item from the cart
- [ ] Validate that the trip `id` exists before adding it to the cart
- [ ] Format prices with `number_format()` in the cart
- [ ] Move categories into their own table instead of `SELECT DISTINCT`
- [ ] Store orders in the database after payment
- [ ] JSON endpoint / REST API for the catalog
- [ ] User accounts and admin panel to manage trips
## 📄 License

Released under the [MIT License](LICENSE).

---
Designed by Maria.
