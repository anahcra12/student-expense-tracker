<?php
require_once 'config/db.php';
$pageTitle = 'Transactions';
$filter = $_GET['type'] ?? 'all';
$sql = 'SELECT * FROM transactions'; $params = [];
if (in_array($filter, ['income', 'expense'], true)) { $sql .= ' WHERE type = ?'; $params[] = $filter; }
$sql .= ' ORDER BY transaction_date DESC, id DESC';
$stmt = $pdo->prepare($sql); $stmt->execute($params); $transactions = $stmt->fetchAll();
require 'includes/header.php';
?>
<section class="page-heading"><div><p class="eyebrow">YOUR RECORDS</p><h1>Transactions</h1><p class="muted">View and manage all your entries.</p></div><a class="button" href="add_transaction.php">+ Add transaction</a></section>
<?php if (($_GET['message'] ?? '') === 'added'): ?><div class="alert success">Transaction added successfully.</div><?php elseif (($_GET['message'] ?? '') === 'updated'): ?><div class="alert success">Transaction updated successfully.</div><?php elseif (($_GET['message'] ?? '') === 'deleted'): ?><div class="alert success">Transaction deleted successfully.</div><?php endif; ?>
<section class="panel"><div class="filter-row"><strong>All records</strong><div class="filters"><a class="filter <?php echo $filter === 'all' ? 'active' : ''; ?>" href="transactions.php">All</a><a class="filter <?php echo $filter === 'income' ? 'active' : ''; ?>" href="?type=income">Income</a><a class="filter <?php echo $filter === 'expense' ? 'active' : ''; ?>" href="?type=expense">Expenses</a></div></div>
<?php if (!$transactions): ?><p class="empty">No transactions found.</p><?php else: ?><div class="table-wrap"><table><thead><tr><th>Title</th><th>Category</th><th>Date</th><th>Type</th><th>Amount</th><th>Actions</th></tr></thead><tbody>
<?php foreach ($transactions as $item): ?><tr><td><?php echo htmlspecialchars($item['title']); ?><?php if ($item['notes']): ?><small class="table-note"><?php echo htmlspecialchars($item['notes']); ?></small><?php endif; ?></td><td><?php echo htmlspecialchars($item['category']); ?></td><td><?php echo htmlspecialchars($item['transaction_date']); ?></td><td><span class="tag <?php echo $item['type']; ?>"><?php echo ucfirst($item['type']); ?></span></td><td class="amount <?php echo $item['type'] === 'income' ? 'green' : 'red'; ?>">₹<?php echo number_format($item['amount'], 2); ?></td><td class="actions"><a href="edit_transaction.php?id=<?php echo (int)$item['id']; ?>">Edit</a><form method="POST" action="delete_transaction.php" class="inline-form" onsubmit="return confirmDelete();"><input type="hidden" name="id" value="<?php echo (int)$item['id']; ?>"><button class="link-danger" type="submit">Delete</button></form></td></tr><?php endforeach; ?>
</tbody></table></div><?php endif; ?></section>
<?php require 'includes/footer.php'; ?>
