# StatusFlow — PHP, MySQL & AJAX Mini App

StatusFlow is a simple web-development task built with **HTML, CSS, JavaScript, PHP, and MySQL**. It demonstrates how a frontend form can save data to a database and update records asynchronously without refreshing the page.

## Live Demo

🌐 [View the live website](http://arwa1188.kesug.com)

## Features

- Add a person's **name** and **age**.
- Store records in a **MySQL** table.
- Display all saved records below the form.
- Toggle each record's `status` between `0` and `1`.
- Update the status instantly using the **Fetch API (AJAX)** without a page refresh.
- Responsive and clean user interface.
- Server-side validation and prepared SQL statements.

## Project Structure

```text
statusflow/
├── api/
│   ├── create.php
│   └── toggle.php
├── assets/
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── app.js
├── .gitignore
├── config.example.php
├── database.sql
├── index.php
└── README.md
```

> `config.php` is intentionally excluded from GitHub because it contains the real database credentials.

## 1. Create the MySQL Database

1. Open your InfinityFree hosting account.
2. Open **MySQL Databases**.
3. Create a database and save these values:
   - MySQL Hostname
   - Database Name
   - Username
   - MySQL Password
4. Open **phpMyAdmin** for that database.
5. Import the file `database.sql`.

The table contains:

| Column | Type | Purpose |
|---|---|---|
| `id` | INT | Auto-increment primary key |
| `name` | VARCHAR(100) | Person name |
| `age` | TINYINT | Person age |
| `status` | TINYINT(1) | Toggle value: 0 or 1 |
| `created_at` | TIMESTAMP | Creation time |

## 2. Configure the Database Connection

Copy:

```text
config.example.php
```

to:

```text
config.php
```

Then replace the placeholders with the exact values from the InfinityFree MySQL page:

```php
$DB_HOST = 'sqlXXX.infinityfree.com';
$DB_NAME = 'if0_XXXXXXXX_statusflow';
$DB_USER = 'if0_XXXXXXXX';
$DB_PASS = 'YOUR_MYSQL_PASSWORD';
```

Do **not** publish the real `config.php` file on GitHub.

## 3. Upload to InfinityFree

1. Open **File Manager** in InfinityFree.
2. Open the website's `htdocs` folder.
3. Upload the project files and folders into `htdocs`.
4. Make sure `index.php` is directly inside `htdocs` (or inside the project folder if you want the URL to include that folder name).
5. Create/edit `config.php` on the server with your real database credentials.
6. Open your InfinityFree domain in the browser.

## 4. How the App Works

### Adding a Record

1. The user enters a name and age in the HTML form.
2. JavaScript prevents the normal page refresh.
3. `fetch()` sends the form data to `api/create.php`.
4. PHP validates the values.
5. A prepared SQL statement inserts the record into MySQL.
6. PHP returns the new record as JSON.
7. JavaScript immediately inserts the record into the table.

### Toggling the Status

1. The user clicks **Toggle**.
2. JavaScript sends the record ID to `api/toggle.php` with `fetch()`.
3. PHP runs:

```sql
UPDATE users SET status = 1 - status WHERE id = :id;
```

4. MySQL changes `0 → 1` or `1 → 0`.
5. PHP returns the updated status as JSON.
6. JavaScript updates the status badge without reloading the page.

## Technologies

- HTML5
- CSS3
- JavaScript (Fetch API)
- PHP (PDO)
- MySQL
- InfinityFree Hosting

## Security / Code Quality

- PDO prepared statements are used instead of placing user values directly in SQL queries.
- The name is escaped before it is printed in HTML.
- Name and age are validated on both the client and server.
- Database credentials are excluded from Git using `.gitignore`.

## Task Requirements Coverage

- [x] HTML, CSS, JavaScript and PHP webpage
- [x] Name + age + submit form
- [x] Save submitted data to MySQL
- [x] Display all records in a table
- [x] Toggle status between 0 and 1
- [x] Update status immediately without page refresh
- [x] GitHub-ready structure and documentation

