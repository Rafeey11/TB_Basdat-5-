<?php
include '../db.php';

$id = $_GET['id'];


$sql = "DELETE FROM stock_ins WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: stock_in_list.php");
exit;
?>
