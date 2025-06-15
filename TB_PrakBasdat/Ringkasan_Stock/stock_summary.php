<?php
include '../db.php';

$sql = "
SELECT 
    i.id,
    i.item_name,
    i.stock AS current_stock,
    COALESCE(SUM(si.quantity), 0) AS total_masuk,
    COALESCE(SUM(so.quantity), 0) AS total_keluar,
    COALESCE(SUM(si.quantity), 0) - COALESCE(SUM(so.quantity), 0) AS hasil_perhitungan
FROM items i
LEFT JOIN stock_ins si ON i.id = si.item_id
LEFT JOIN stock_outs so ON i.id = so.item_id
GROUP BY i.id
ORDER BY i.item_name ASC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>📊 Ringkasan Stok Barang</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"  rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <!-- Custom CSS -->
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); 
      min-height: 100vh;
    }

    .container {
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .table th, .table td {
      vertical-align: middle;
    }

    .badge-success {
      background-color: #28a745;
    }

    .badge-danger {
      background-color: #dc3545;
    }

    a {
      color: #1e3c72;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">📦 Gudang Sepatu</a>
    <a class="nav-link text-white" href="../index.php">⬅ Kembali</a>
  </div>
</nav>

<!-- Main Content -->
<div class="container mt-4">
  <h2 class="mb-4 text-center">📊 Ringkasan Stok Barang</h2>

  <div class="table-responsive">
    <table class="table table-striped table-hover align-middle text-center">
      <thead class="table-dark">
        <tr>
          <th>Nama Barang</th>
          <th>Total Masuk</th>
          <th>Total Keluar</th>
          <th>Hasil Perhitungan</th>
          <th>Stok Tersimpan</th>
          <th>Catatan</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($row['item_name']) ?></td>
          <td><?= $row['total_masuk'] ?></td>
          <td><?= $row['total_keluar'] ?></td>
          <td><?= $row['hasil_perhitungan'] ?></td>
          <td><?= $row['current_stock'] ?></td>
          <td>
            <?php if ($row['hasil_perhitungan'] == $row['current_stock']): ?>
              <span class="badge rounded-pill badge-success px-3 py-2">✔ Sesuai</span>
            <?php else: ?>
              <span class="badge rounded-pill badge-danger px-3 py-2">❌ Tidak Sesuai</span>
            <?php endif; ?>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>