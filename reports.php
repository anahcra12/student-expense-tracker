<?php
require_once 'config/db.php';
$pageTitle = 'Reports';
$month = $_GET['month'] ?? date('Y-m');
if (!preg_match('/^\d{4}-\d{2}$/', $month)) $month = date('Y-m');
$start = $month . '-01'; $end = date('Y-m-t', strtotime($start));
$summary = $pdo->prepare("SELECT type, COALESCE(SUM(amount),0) AS total FROM transactions WHERE transaction_date BETWEEN ? AND ? GROUP BY type");
$summary->execute([$start,$end]); $totals = ['income'=>0,'expense'=>0]; foreach ($summary as $row) $totals[$row['type']] = (float)$row['total'];
$categoryStmt = $pdo->prepare("SELECT category, SUM(amount) AS total FROM transactions WHERE type='expense' AND transaction_date BETWEEN ? AND ? GROUP BY category ORDER BY total DESC");
$categoryStmt->execute([$start,$end]); $categories = $categoryStmt->fetchAll();
require 'includes/header.php';
?>
<section class="page-heading"><div><p class="eyebrow">UNDERSTAND YOUR SPENDING</p><h1>Monthly reports</h1><p class="muted">A summary of your income and expenses for a selected month.</p></div></section>
<section class="panel"><form method="GET" class="month-form"><label for="month">Choose month</label><input id="month" type="month" name="month" value="<?php echo htmlspecialchars($month); ?>"><button class="button small-button" type="submit">View report</button></form>
<div class="summary-grid report-grid"><article class="summary-card"><span>Monthly income</span><strong class="green">₹<?php echo number_format($totals['income'],2); ?></strong></article><article class="summary-card"><span>Monthly expenses</span><strong class="red">₹<?php echo number_format($totals['expense'],2); ?></strong></article><article class="summary-card"><span>Monthly balance</span><strong>₹<?php echo number_format($totals['income']-$totals['expense'],2); ?></strong></article></div>
<h2 class="subheading">Expense by category</h2>
<?php if (!$categories): ?><p class="empty">No expense records for this month.</p><?php else: ?><div class="category-list"><?php $max = max(array_column($categories, 'total')); foreach ($categories as $item): $percent = $max > 0 ? ($item['total']/$max)*100 : 0; ?><div class="category-item"><div class="category-label"><span><?php echo htmlspecialchars($item['category']); ?></span><strong>₹<?php echo number_format($item['total'],2); ?></strong></div><div class="bar-track"><div class="bar-fill" style="width: <?php echo $percent; ?>%"></div></div></div><?php endforeach; ?></div><?php endif; ?></section>
<?php require 'includes/footer.php'; ?>
