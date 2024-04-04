<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $conn->real_escape_string($_POST['email']);
  $password = $conn->real_escape_string($_POST['password']);
  $passwordConfirm = $conn->real_escape_string($_POST['passwordConfirm']);

  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  if ($password === $passwordConfirm) {
    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$hashed_password')";
    if ($conn->query($sql) === TRUE) {
      echo "Register Successfull";
      header('location: index.php');
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }else{
    echo "Password does not match with confirmation";
  }

  $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Web Data Mahasiswa</title>
  <link rel="stylesheet" href="/data-mahasiswa/assets/style.css">
</head>
<body>
<div class="container">
    <div class="headline">
      <h1 class="title">Register</h1>
      <p class="subtitle">Daftar akun untuk mengakses website</p>
    </div>
    <div class="card">
      <div class="card-content">
        <form action="" method="post">
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control">
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control">
          </div>
          <div class="form-group">
            <label for="passwordConfirm">Konfirmasi Password</label>
            <input type="password" name="passwordConfirm" id="passwordConfirm" class="form-control">
          </div>
          <button type="submit" class="primary-btn">Login</button>
        </form>
        <a href="registrasi.php" class="primary-btn-outline">Registrasi</a>
      </div>
    </div>
  </div>
</body>
</html>