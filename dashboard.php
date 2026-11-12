<?php
require_once 'config/db.php';
$pageTitle = 'Dashboard';
$income = (float)$pdo->query("SELECT COALESCE(SUM(amount), 0) FROM transactions WHERE type = 'income'")->fetchColumn();
$expenses = (float)$pdo->query("SELECT COALESCE(SUM(amount), 0) FROM transactions WHERE type = 'expense'")->fetchColumn();
$balance = $income - $expenses;
$recent = $pdo->query('SELECT * FROM transactions ORDER BY transaction_date DESC, id DESC LIMIT 5')->fetchAll();
require 'includes/header.php';
?>
<section class="page-heading">
    <div><p class="eyebrow">YOUR MONEY, MADE SIMPLE</p><h1>Dashboard</h1><p class="muted">A quick overview of your personal finances.</p></div>
    <a class="button" href="add_transaction.php">+ Add transaction</a>
</section>
<section class="summary-grid">
    <article class="summary-card"><span>Total income</span><strong class="green">₹<?php echo number_format($income, 2); ?></strong></article>
    <article class="summary-card"><span>Total expenses</span><strong class="red">₹<?php echo number_format($expenses, 2); ?></strong></article>
    <article class="summary-card"><span>Current balance</span><strong>₹<?php echo number_format($balance, 2); ?></strong></article>
</section>
<section class="panel">
    <div class="panel-heading"><h2>Recent transactions</h2><a href="transactions.php">View all</a></div>
    <?php if (!$recent): ?><p class="empty">No transactions yet. Add your first transaction to get started.</p>
    <?php else: ?>
    <div class="table-wrap"><table><thead><tr><th>Title</th><th>Category</th><th>Date</th><th>Type</th><th>Amount</th></tr></thead><tbody>
    <?php foreach ($recent as $item): ?>
      <tr><td><?php echo htmlspecialchars($item['title']); ?></td><td><?php echo htmlspecialchars($item['category']); ?></td><td><?php echo htmlspecialchars($item['transaction_date']); ?></td><td><span class="tag <?php echo $item['type']; ?>"><?php echo ucfirst($item['type']); ?></span></td><td class="amount <?php echo $item['type'] === 'income' ? 'green' : 'red'; ?>"><?php echo $item['type'] === 'income' ? '+' : '-'; ?>₹<?php echo number_format($item['amount'], 2); ?></td></tr>
    <?php endforeach; ?>
    </tbody></table></div><?php endif; ?>
</section>
<?php require 'includes/footer.php'; ?>
