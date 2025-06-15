<?php
include '../db.php';

$id = $_POST['id'];
$item_id = $_POST['item_id'];
$quantity = $_POST['quantity'];
$date_in = $_POST['date_in'];
$notes = $_POST['notes'];

$sql = "UPDATE stock_ins 
        SET item_id = ?, quantity = ?, date_in = ?, notes = ? 
        WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iissi", $item_id, $quantity, $date_in, $notes, $id);
$stmt->execute();

header("Location: stock_in_list.php");
exit;
?>
