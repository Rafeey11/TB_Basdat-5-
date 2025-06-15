<?php
include '../db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM stock_ins WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

$item_result = $conn->query("SELECT * FROM items");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>✏ Edit Data Barang Masuk</title>

 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"  rel="stylesheet">

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">


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

    .form-control, .form-select {
      background-color: #f8f9fa;
    }

    .btn-primary {
      background-color: #1e3c72;
      border: none;
    }

    .btn-primary:hover {
      background-color: #2a5298;
      transform: scale(1.03);
      transition: all 0.3s ease;
    }

    label {
      font-weight: 500;
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


<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">📦 Gudang Sepatu</a>
    <a class="nav-link text-white" href="stock_in_list.php">⬅ Kembali</a>
  </div>
</nav>

<div class="container mt-5">
  <h2 class="mb-4 text-center">✏ Edit Data Barang Masuk</h2>

  <form method="post" action="update.php">
    <input type="hidden" name="id" value="<?= $data['id'] ?>">

    <div class="row mb-3">
      <div class="col-md-6 offset-md-3">
        <label for="item_id" class="form-label">Nama Barang:</label>
        <select name="item_id" id="item_id" class="form-select" required>
          <?php while ($item = $item_result->fetch_assoc()): ?>
            <option value="<?= $item['id'] ?>" <?= $item['id'] == $data['item_id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($item['item_name']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-6 offset-md-3">
        <label for="quantity" class="form-label">Jumlah Masuk:</label>
        <input type="number" name="quantity" id="quantity" class="form-control" value="<?= $data['quantity'] ?>" required>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-6 offset-md-3">
        <label for="date_in" class="form-label">Tanggal Masuk:</label>
        <input type="date" name="date_in" id="date_in" class="form-control" value="<?= $data['date_in'] ?>" required>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-6 offset-md-3">
        <label for="notes" class="form-label">Catatan:</label>
        <textarea name="notes" id="notes" class="form-control" rows="3"><?= htmlspecialchars($data['notes']) ?></textarea>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6 offset-md-3 d-grid">
        <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
      </div>
    </div>
  </form>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>