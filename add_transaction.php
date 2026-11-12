<?php
require_once 'config/db.php';
$pageTitle = 'Add Transaction';
$errors = [];
$title = $category = $type = $amount = $date = $notes = '';
$categories = ['Food', 'Travel', 'Education', 'Shopping', 'Bills', 'Entertainment', 'Salary', 'Scholarship', 'Other'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $category = $_POST['category'] ?? '';
    $type = $_POST['type'] ?? '';
    $amount = $_POST['amount'] ?? '';
    $date = $_POST['transaction_date'] ?? '';
    $notes = trim($_POST['notes'] ?? '');
    if ($title === '') $errors[] = 'Please enter a transaction title.';
    if (!in_array($category, $categories, true)) $errors[] = 'Please select a valid category.';
    if (!in_array($type, ['income', 'expense'], true)) $errors[] = 'Please select income or expense.';
    if (!is_numeric($amount) || (float)$amount <= 0) $errors[] = 'Amount must be greater than zero.';
    $dateObject = DateTime::createFromFormat('Y-m-d', $date);
    if (!$dateObject || $dateObject->format('Y-m-d') !== $date) $errors[] = 'Please enter a valid date.';
    if (!$errors) {
        $stmt = $pdo->prepare('INSERT INTO transactions (title, category, type, amount, transaction_date, notes) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->execute([$title, $category, $type, $amount, $date, $notes]);
        header('Location: transactions.php?message=added'); exit;
    }
}
require 'includes/header.php';
?>
<section class="page-heading"><div><p class="eyebrow">RECORD YOUR MONEY</p><h1>Add transaction</h1><p class="muted">Enter income or an expense below.</p></div></section>
<section class="panel form-panel">
<?php if ($errors): ?><div class="alert error"><?php foreach ($errors as $error): ?><p><?php echo htmlspecialchars($error); ?></p><?php endforeach; ?></div><?php endif; ?>
<form method="POST" action="">
    <label>Title<input type="text" name="title" maxlength="100" placeholder="e.g. Lunch at college" value="<?php echo htmlspecialchars($title); ?>" required></label>
    <div class="form-row">
      <label>Type<select name="type" required><option value="">Select type</option><option value="income" <?php echo $type === 'income' ? 'selected' : ''; ?>>Income</option><option value="expense" <?php echo $type === 'expense' ? 'selected' : ''; ?>>Expense</option></select></label>
      <label>Category<select name="category" required><option value="">Select category</option><?php foreach ($categories as $option): ?><option value="<?php echo htmlspecialchars($option); ?>" <?php echo $category === $option ? 'selected' : ''; ?>><?php echo htmlspecialchars($option); ?></option><?php endforeach; ?></select></label>
    </div>
    <div class="form-row"><label>Amount (₹)<input type="number" name="amount" min="0.01" step="0.01" placeholder="0.00" value="<?php echo htmlspecialchars((string)$amount); ?>" required></label><label>Date<input type="date" name="transaction_date" value="<?php echo htmlspecialchars($date ?: date('Y-m-d')); ?>" required></label></div>
    <label>Notes <span class="muted">(optional)</span><textarea name="notes" rows="3" placeholder="Add a short note"><?php echo htmlspecialchars($notes); ?></textarea></label>
    <button class="button" type="submit">Save transaction</button>
</form></section>
<?php require 'includes/footer.php'; ?>
