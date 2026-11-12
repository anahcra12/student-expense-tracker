# Student Expense Tracker

A beginner-friendly personal finance web application built with Core PHP, MySQL, HTML, CSS and JavaScript. It is intended to run locally using XAMPP.

## Features
- Dashboard showing total income, total expenses and current balance.
- Add, view, edit and delete income/expense transactions.
- Categories such as Food, Travel, Education, Shopping, Salary and Other.
- Filter transactions by income or expense.
- Monthly income/expense summary and category-wise expense report.
- Basic server-side validation and PDO prepared statements.

## Requirements
- XAMPP with Apache, PHP and MySQL/MariaDB.
- A web browser.

## Setup on Windows using XAMPP
1. Extract the `Student-Expense-Tracker` folder.
2. Copy it into `C:\xampp\htdocs\`.
3. Open the XAMPP Control Panel and start **Apache** and **MySQL**.
4. Visit `http://localhost/phpmyadmin` in your browser.
5. Select **Import**, choose `database/expense_tracker.sql`, and click **Import** or **Go**.
6. Open `http://localhost/Student-Expense-Tracker/`.

The database connection is configured in `config/db.php` for the usual XAMPP defaults (`root` with an empty password). If your MySQL credentials are different, update that file.

## How to test
1. Open **Add Transaction** and add an income record (for example, pocket money).
2. Add an expense record (for example, food or travel).
3. Open **Dashboard** to see totals and recent transactions.
4. Open **Transactions** to filter, edit or delete records.
5. Open **Reports**, choose a month and view its summary and category-wise expenses.

## Main database table
`transactions` stores the title, category, type, amount, date and optional notes for each transaction. The dashboard and report pages calculate totals using SQL aggregate functions such as `SUM()` and `GROUP BY`.

## Notes
This is a learning project, not a production financial service. It has no login or multi-user support. Add authentication, CSRF protection and stronger deployment configuration before hosting it publicly. Sample rows are included in the SQL file so the dashboard is not empty on first launch.
