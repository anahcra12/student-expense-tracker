<?php
require_once 'config/db.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if ($id) { $stmt = $pdo->prepare('DELETE FROM transactions WHERE id = ?'); $stmt->execute([$id]); }
}
header('Location: transactions.php?message=deleted');
exit;
?>
