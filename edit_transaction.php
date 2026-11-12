<?php
require_once 'config/db.php';
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) { header('Location: transactions.php'); exit; }
$stmt = $pdo->prepare('SELECT * FROM transactions WHERE id = ?'); $stmt->execute([$id]); $transaction = $stmt->fetch();
if (!$transaction) { header('Location: transactions.php'); exit; }
$pageTitle = 'Edit Transaction'; $errors = [];
$categories = ['Food', 'Travel', 'Education', 'Shopping', 'Bills', 'Entertainment', 'Salary', 'Scholarship', 'Other'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? ''); $category = $_POST['category'] ?? ''; $type = $_POST['type'] ?? ''; $amount = $_POST['amount'] ?? ''; $date = $_POST['transaction_date'] ?? ''; $notes = trim($_POST['notes'] ?? '');
    if ($title === '') $errors[] = 'Title is required.';
    if (!in_array($category, $categories, true)) $errors[] = 'Select a valid category.';
    if (!in_array($type, ['income', 'expense'], true)) $errors[] = 'Select a valid type.';
    if (!is_numeric($amount) || (float)$amount <= 0) $errors[] = 'Amount must be greater than zero.';
    $dateObject = DateTime::createFromFormat('Y-m-d', $date);
    if (!$dateObject || $dateObject->format('Y-m-d') !== $date) $errors[] = 'Enter a valid date.';
    if (!$errors) { $update = $pdo->prepare('UPDATE transactions SET title=?, category=?, type=?, amount=?, transaction_date=?, notes=? WHERE id=?'); $update->execute([$title,$category,$type,$amount,$date,$notes,$id]); header('Location: transactions.php?message=updated'); exit; }
    $transaction = array_merge($transaction, ['title'=>$title,'category'=>$category,'type'=>$type,'amount'=>$amount,'transaction_date'=>$date,'notes'=>$notes]);
}
require 'includes/header.php';
?>
<section class="page-heading"><div><p class="eyebrow">UPDATE YOUR RECORD</p><h1>Edit transaction</h1></div></section>
<section class="panel form-panel"><?php if ($errors): ?><div class="alert error"><?php foreach ($errors as $error): ?><p><?php echo htmlspecialchars($error); ?></p><?php endforeach; ?></div><?php endif; ?>
<form method="POST"><label>Title<input name="title" maxlength="100" value="<?php echo htmlspecialchars($transaction['title']); ?>" required></label><div class="form-row"><label>Type<select name="type" required><option value="income" <?php echo $transaction['type']==='income'?'selected':''; ?>>Income</option><option value="expense" <?php echo $transaction['type']==='expense'?'selected':''; ?>>Expense</option></select></label><label>Category<select name="category" required><?php foreach ($categories as $option): ?><option value="<?php echo htmlspecialchars($option); ?>" <?php echo $transaction['category']===$option?'selected':''; ?>><?php echo htmlspecialchars($option); ?></option><?php endforeach; ?></select></label></div><div class="form-row"><label>Amount (₹)<input type="number" name="amount" min="0.01" step="0.01" value="<?php echo htmlspecialchars((string)$transaction['amount']); ?>" required></label><label>Date<input type="date" name="transaction_date" value="<?php echo htmlspecialchars($transaction['transaction_date']); ?>" required></label></div><label>Notes<textarea name="notes" rows="3"><?php echo htmlspecialchars($transaction['notes'] ?? ''); ?></textarea></label><button class="button" type="submit">Update transaction</button> <a class="cancel-link" href="transactions.php">Cancel</a></form></section>
<?php require 'includes/footer.php'; ?>
