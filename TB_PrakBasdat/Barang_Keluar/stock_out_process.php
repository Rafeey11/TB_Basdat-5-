<?php
include '../db.php';

$item_id = $_POST['item_id'];
$quantity = $_POST['quantity'];
$date_out = $_POST['date_out'];
$destination = $_POST['destination'];
$notes = $_POST['notes'];

// Ambil stok saat ini
$result = $conn->prepare("SELECT stock FROM items WHERE id = ?");
$result->bind_param("i", $item_id);
$result->execute();
$result->bind_result($current_stock);
$result->fetch();
$result->close();

if ($quantity > $current_stock) {
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
        <p>Stok saat ini hanya tersisa <strong>' . $current_stock . '</strong>.</p>
        <a href="stock_out_form.php" class="btn btn-custom w-100">Coba Lagi</a>
    </div>

    </body>
    </html>
    ';
    exit;
}

// Simpan ke stock_outs
$stmt = $conn->prepare("INSERT INTO stock_outs (item_id, quantity, date_out, destination, notes) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iisss", $item_id, $quantity, $date_out, $destination, $notes);

if ($stmt->execute()) {
    // Kurangi stok
    $update = $conn->prepare("UPDATE items SET stock = stock - ? WHERE id = ?");
    $update->bind_param("ii", $quantity, $item_id);
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
        <p>Barang keluar berhasil disimpan.</p>
        <a href="../index.php" class="btn btn-custom w-100">Kembali ke Beranda</a>
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
        <p>Gagal menyimpan data barang keluar.</p>
        <a href="stock_out_form.php" class="btn btn-custom w-100">Coba Lagi</a>
    </div>

    </body>
    </html>
    ';
}
?>