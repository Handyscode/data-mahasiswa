<?php
session_start();
include 'connection.php';

if (isset($_SESSION['loggedin'])) {
  header( "Location: dashboard.php" );
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $conn->real_escape_string($_POST['email']);
  var_dump($email);
  $password = $_POST['password'];  // Get the password directly without real_escape_string for checking

  $sql = "SELECT id, password FROM users WHERE email = '$email'";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();

      // Debugging: Check what's fetched from the database
      // Remove this line in production
      echo "DB Password: " . $row['password'] . "<br>";

      if (password_verify($password, $row['password'])) {
          $_SESSION['loggedin'] = true;
          $_SESSION['email'] = $email;
          header("Location: dashboard.php");
      } else {
          // Additional debug info
          echo "Password from form: " . $password . "<br>";
          echo "Hashed Password from form: " . password_hash($password, PASSWORD_DEFAULT) . "<br>";
          echo "Incorrect password";
      }
  } else {
      echo "email does not exist";
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
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100..700;1,100..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
  <div class="container">
    <div class="headline">
      <h1 class="title">Login</h1>
      <p class="subtitle">Login untuk melanjutkan</p>
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
          <button type="submit" class="primary-btn">Login</button>
        </form>
        <a href="registrasi.php" class="primary-btn-outline">Registrasi</a>
      </div>
    </div>
  </div>
</body>
</html>