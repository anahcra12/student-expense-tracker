CREATE DATABASE IF NOT EXISTS student_expense_tracker;
USE student_expense_tracker;

CREATE TABLE IF NOT EXISTS transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    type ENUM('income', 'expense') NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    transaction_date DATE NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Optional sample records for testing. Remove these INSERT statements if you want an empty app.
INSERT INTO transactions (title, category, type, amount, transaction_date, notes) VALUES
('Monthly pocket money', 'Other', 'income', 3000.00, CURDATE(), 'Sample income record'),
('Lunch at college', 'Food', 'expense', 120.00, CURDATE(), 'Sample expense record'),
('Bus fare', 'Travel', 'expense', 40.00, CURDATE(), 'Sample travel expense');
