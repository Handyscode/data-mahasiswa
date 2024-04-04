<?php 
session_start();
include 'connection.php';

$sql = "SELECT * FROM mahasiswa WHERE nim = ". $_GET['nim'];
$mahasiswa = $conn->query($sql)->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $conn->real_escape_string($_POST['nama']);
    $nim = $conn->real_escape_string($_POST['nim']);
    $email = $conn->real_escape_string($_POST['email']);
    $tglLahir = $conn->real_escape_string($_POST['tglLahir']);
    $alamat = $conn->real_escape_string($_POST['alamat']);
    $jurusan = $conn->real_escape_string($_POST['jurusan']);
    $semester = $conn->real_escape_string($_POST['semester']);
    $oldNim = $conn->real_escape_string($_POST['old_nim']);
    
    $checkNIM = "SELECT * FROM mahasiswa WHERE nim = '$nim'";
    $result = $conn->query($checkNIM);

    if ($result->num_rows < 1 || $nim == $oldNim) {
        $sql = "UPDATE mahasiswa SET nim='$nim', nama_mahasiswa='$nama', email='$email', alamat='$alamat', tgl_lahir='$tglLahir', jurusan='$jurusan', semester='$semester' WHERE nim=$oldNim";
    }else{
        echo "NIM sudah terdaftar";
    }

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
        header('location: dashboard.php');
    } else {
        echo "Error updating record: " . $conn->error;
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
    <div class="navbar">
        <p class="navbrand">Web Data Mahasiswa</p>
        <ul class="nav-parent">
            <a href="dashboard.php" class="logoutBtn">
                <li style="color:#fff">Home</li>
            </a>
            <a href="add-mahasiswa.php" class="logoutBtn">
                <li style="color:#fff">Tambah Mahasiswa</li>
            </a>
            <a href="logout.php" class="logoutBtn">
                <li style="color:#fff">Logout</li>
            </a>
        </ul>
    </div>
    <div class="table-container">
        <h1>Edit Data Mahasiswa</h1>
        <div class="card" style="width: 500px;">
            <form action="" method="post">
                <input type="hidden" name="old_nim" value="<?= $mahasiswa['nim'] ?>" class="form-control">
                <div class="form-group">
                    <label for="nim">NIM</label>
                    <input type="number" name="nim" id="nim" value="<?= $mahasiswa['nim'] ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" value="<?= $mahasiswa['nama_mahasiswa'] ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?= $mahasiswa['email'] ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="tglLahir">Tanggal Lahir</label>
                    <input type="date" name="tglLahir" id="tglLahir" value="<?= $mahasiswa['tgl_lahir'] ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Alamat</label>
                    <textarea name="alamat" id="alamat" cols="30" rows="2" class="form-control" required ><?= $mahasiswa['alamat'] ?></textarea>
                </div>
                <div class="form-group">
                    <label for="jurusan">Jurusan</label>
                    <input type="text" name="jurusan" id="jurusan" value="<?= $mahasiswa['jurusan'] ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="semester">Semester</label>
                    <input type="text" name="semester" id="semester" value="<?= $mahasiswa['semester'] ?>"  class="form-control"required>
                </div>
                <button type="submit" class="primary-btn">Update</button>
            </form>
        </div>
    </div>
</body>
</html>