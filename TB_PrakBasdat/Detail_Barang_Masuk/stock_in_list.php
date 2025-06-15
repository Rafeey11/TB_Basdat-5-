<?php
include '../db.php';

// Ambil semua data barang masuk
$sql = "
    SELECT si.id, i.item_name, si.quantity, si.date_in, si.notes, si.created_at
    FROM stock_ins si
    LEFT JOIN items i ON si.item_id = i.id
    ORDER BY si.date_in DESC
";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>📥 Daftar Barang Masuk</title>

  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"  rel="stylesheet">


  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">


  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  
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
    <a class="nav-link text-white" href="../index.php">⬅ Kembali</a>
  </div>
</nav>


<div class="container mt-4">
  <h2 class="mb-4 text-center">📥 Daftar Barang Masuk</h2>

  <div class="table-responsive">
    <table class="table table-striped table-hover align-middle text-center">
      <thead class="table-dark">
        <tr>
          <th>No</th>
          <th>Nama Barang</th>
          <th>Jumlah Masuk</th>
          <th>Tanggal Masuk</th>
          <th>Catatan</th>
          <th>Waktu Input</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; while ($row = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= htmlspecialchars($row['item_name']) ?></td>
          <td><?= $row['quantity'] ?></td>
          <td><?= $row['date_in'] ?></td>
          <td><?= $row['notes'] ?: '<em>-</em>' ?></td>
          <td><?= $row['created_at'] ?></td>
          <td>
            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">✏ Edit</a>
            <a href="delete.php?id=<?= $row['id'] ?>" 
               class="btn btn-sm btn-outline-danger" 
               onclick="confirmDelete(event, this.getAttribute('href'))">
               🗑 Hapus
            </a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>


<script>
function confirmDelete(e, url) {
    e.preventDefault();
    Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: "Data ini akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>