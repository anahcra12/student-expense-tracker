<?php
if (!isset($pageTitle)) { $pageTitle = 'Student Expense Tracker'; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?> | Student Expense Tracker</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js" defer></script>
</head>
<body>
<header class="topbar">
    <a class="brand" href="dashboard.php">Student Expense Tracker</a>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="add_transaction.php">Add Transaction</a>
        <a href="transactions.php">Transactions</a>
        <a href="reports.php">Reports</a>
    </nav>
</header>
<main class="container">
