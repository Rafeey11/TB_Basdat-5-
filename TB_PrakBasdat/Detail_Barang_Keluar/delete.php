<?php
include '../db.php';

$id = $_GET['id'];

// Ambil quantity dan item_id dulu
$stmt = $conn->prepare("SELECT item_id, quantity FROM stock_outs WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($item_id, $quantity);
$stmt->fetch();
$stmt->close();

// Kembalikan stok
$update = $conn->prepare("UPDATE items SET stock = stock + ? WHERE id = ?");
$update->bind_param("ii", $quantity, $item_id);
$update->execute();

// Hapus data
$delete = $conn->prepare("DELETE FROM stock_outs WHERE id = ?");
$delete->bind_param("i", $id);
$delete->execute();

header("Location: stock_out_list.php");
exit;
?>
