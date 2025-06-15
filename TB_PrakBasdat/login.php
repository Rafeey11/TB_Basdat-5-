<?php
session_start();
include 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            header("Location: index.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Akun tidak ditemukan. Silakan register terlebih dahulu.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>🔐 Login - Inventory Gudang Sepatu</title>

  
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

    .form-control {
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
  </div>
</nav>


<div class="container mt-5">
  <h2 class="mb-4 text-center">🔐 Login ke Sistem</h2>

  <?php if (!empty($error)): ?>
    <div class="alert alert-danger text-center" role="alert">
      <?= $error ?>
    </div>
  <?php endif; ?>

  <div class="row justify-content-center">
    <div class="col-md-6">
      <form method="POST">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" name="username" class="form-control" id="username" placeholder="Masukkan username" required>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" name="password" class="form-control" id="password" placeholder="Masukkan password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
      </form>
    </div>
  </div>

  <p class="mt-3 text-center">Belum punya akun? <a href="register.php">Daftar disini</a></p>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> 
</body>
</html>