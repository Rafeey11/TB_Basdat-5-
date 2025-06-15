<?php
include 'db.php';

$result = $conn->query("
    SELECT i.id, i.item_name, c.category_name, i.stock, i.unit, i.created_at
    FROM items i
    LEFT JOIN categories c ON i.category_id = c.id
    ORDER BY i.item_name ASC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>📦 Inventory Gudang Sepatu</title>

  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"  rel="stylesheet">

  
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">


  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%); 
      min-height: 100vh;
    }
    .table th, .table td {
      vertical-align: middle;
    }
    .status-banyak { color: green; }
    .status-hampir-habis { color: orange; }
    .status-habis { color: red; }
    .navbar-brand {
      font-weight: 600;
    }
    .container {
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">📦 Gudang Sepatu</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="Barang_Masuk/stock_in_form.php">➕ Barang Masuk</a></li>
        <li class="nav-item"><a class="nav-link" href="Barang_Keluar/stock_out_form.php">➖ Barang Keluar</a></li>
        <li class="nav-item"><a class="nav-link" href="Ringkasan_Stock/stock_summary.php">📊 Ringkasan Stok</a></li>
        <li class="nav-item"><a class="nav-link" href="Detail_Barang_Masuk/stock_in_list.php">📥 Detail Masuk</a></li>
        <li class="nav-item"><a class="nav-link" href="Detail_Barang_Keluar/stock_out_list.php">📤 Detail Keluar</a></li>
      </ul>
    </div>
  </div>
</nav>


<div class="container mt-4">
  <h2 class="mb-4 text-center">📦 Data Stok Barang</h2>

  <table class="table table-striped table-hover table-bordered align-middle">
    <thead class="table-dark text-center">
      <tr>
        <th>No</th>
        <th>Nama Barang</th>
        <th>Kategori</th>
        <th>Stok</th>
        <th>Satuan</th>
        <th>Dibuat</th>
        <th>Status Stok</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $no = 1;
      while ($row = $result->fetch_assoc()):
      ?>
      <tr>
        <td class="text-center"><?= $no++ ?></td>
        <td><?= htmlspecialchars($row['item_name']) ?></td>
        <td><?= htmlspecialchars($row['category_name']) ?></td>
        <td class="text-center"><?= $row['stock'] ?></td>
        <td class="text-center"><?= $row['unit'] ?></td>
        <td class="text-center"><?= $row['created_at'] ?></td>
        <td class="text-center">
          <?php
            if ($row['stock'] == 0) {
                echo "<span class='status-habis'>Habis ❌</span>";
            } elseif ($row['stock'] <= 9) {
                echo "<span class='status-hampir-habis'>Hampir Habis ⚠️</span>";
            } else {
                echo "<span class='status-banyak'>Banyak ✅</span>";
            }
          ?>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>