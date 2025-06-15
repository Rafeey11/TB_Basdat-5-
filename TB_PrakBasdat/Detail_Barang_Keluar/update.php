<?php
include '../db.php';

$id = $_POST['id'];
$item_id = $_POST['item_id'];
$quantity = $_POST['quantity'];
$date_out = $_POST['date_out'];
$destination = $_POST['destination'];
$notes = $_POST['notes'];

// Ambil data lama
$stmt_old = $conn->prepare("SELECT quantity FROM stock_outs WHERE id = ?");
$stmt_old->bind_param("i", $id);
$stmt_old->execute();
$stmt_old->bind_result($old_quantity);
$stmt_old->fetch();
$stmt_old->close();

// Ambil stok saat ini
$stmt_stock = $conn->prepare("SELECT stock FROM items WHERE id = ?");
$stmt_stock->bind_param("i", $item_id);
$stmt_stock->execute();
$stmt_stock->bind_result($current_stock);
$stmt_stock->fetch();
$stmt_stock->close();

// Kembalikan stok lama
$restored_stock = $current_stock + $old_quantity;

// Validasi stok
if ($quantity > $restored_stock) {
    echo '
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Error Stok</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"  rel="stylesheet">
        <style>
            body {
                font-family: "Poppins", sans-serif;
                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .card-error {
                background-color: rgba(255, 255, 255, 0.9);
                border-radius: 12px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                padding: 30px;
                max-width: 500px;
                width: 100%;
                text-align: center;
            }
            .btn-custom {
                background-color: #1e3c72;
                color: white;
            }
            .btn-custom:hover {
                background-color: #2a5298;
                transform: scale(1.03);
                transition: all 0.3s ease;
            }
        </style>
    </head>
    <body>

    <div class="card-error">
        <h2 class="text-danger mb-3">❌ Stok Tidak Cukup</h2>
        <p>Stok saat ini hanya tersisa <strong>' . $restored_stock . '</strong>.</p>
        <a href="edit.php?id=' . $id . '" class="btn btn-custom w-100">Coba Lagi</a>
    </div>

    </body>
    </html>
    ';
    exit;
}

// Update ke stock_outs
$stmt = $conn->prepare("UPDATE stock_outs SET item_id = ?, quantity = ?, date_out = ?, destination = ?, notes = ? WHERE id = ?");
$stmt->bind_param("iisssi", $item_id, $quantity, $date_out, $destination, $notes, $id);

if ($stmt->execute()) {
    // Update stok baru
    $new_stock = $restored_stock - $quantity;
    $update = $conn->prepare("UPDATE items SET stock = ? WHERE id = ?");
    $update->bind_param("ii", $new_stock, $item_id);
    $update->execute();

    echo '
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Sukses</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"  rel="stylesheet">
        <style>
            body {
                font-family: "Poppins", sans-serif;
                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .card-success {
                background-color: rgba(255, 255, 255, 0.9);
                border-radius: 12px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                padding: 30px;
                max-width: 500px;
                width: 100%;
                text-align: center;
            }
            .btn-custom {
                background-color: #1e3c72;
                color: white;
            }
            .btn-custom:hover {
                background-color: #2a5298;
                transform: scale(1.03);
                transition: all 0.3s ease;
            }
        </style>
    </head>
    <body>

    <div class="card-success">
        <h2 class="text-success mb-3">✅ Berhasil!</h2>
        <p>Data barang keluar berhasil diperbarui.</p>
        <a href="stock_out_list.php" class="btn btn-custom w-100">Kembali ke Daftar</a>
    </div>

    </body>
    </html>
    ';
} else {
    echo '
    <!DOCTYPE html>
    <html lang="id">
    <head>
        <meta charset="UTF-8">
        <title>Error</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"  rel="stylesheet">
        <style>
            body {
                font-family: "Poppins", sans-serif;
                background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .card-error {
                background-color: rgba(255, 255, 255, 0.9);
                border-radius: 12px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                padding: 30px;
                max-width: 500px;
                width: 100%;
                text-align: center;
            }
            .btn-custom {
                background-color: #1e3c72;
                color: white;
            }
            .btn-custom:hover {
                background-color: #2a5298;
                transform: scale(1.03);
                transition: all 0.3s ease;
            }
        </style>
    </head>
    <body>

    <div class="card-error">
        <h2 class="text-danger mb-3">❌ Gagal</h2>
        <p>Gagal memperbarui data barang keluar.</p>
        <a href="edit.php?id=' . $id . '" class="btn btn-custom w-100">Coba Lagi</a>
    </div>

    </body>
    </html>
    ';
}
?>