<?php
session_start();
include 'connection.php';
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}

$userAuth = $_SESSION['email'];

$sql = "SELECT * FROM mahasiswa";
$result = $conn->query( $sql ); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $conn->real_escape_string($_POST['nim']);

    $sql = "DELETE FROM mahasiswa WHERE nim=$nim";

    if ($conn->query($sql) === TRUE) {
        echo "Berhasil menghapus data";
        header('location: dashboard.php');
    } else {
        echo "Error deleting record: " . $conn->error;
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
        <h1>Data Mahasiswa</h1>
        <?php 
            if (isset($_SESSION['message'])) {
                echo 
                "<div>
                    <p>".$_SESSION['message']."</p>
                </div";
            }
        ?>
        <div class="table-card">
            <table class="table-parent">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th>Alamat</th>
                        <th>Tanggal Lahir</th>
                        <th>Jurusan</th>
                        <th>Semester</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        if ($result->num_rows > 0) {
                            $num = 1;
                            while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?= $num ?></td>
                        <td><?= $row['nim'] ?></td>
                        <td><?= $row['nama_mahasiswa'] ?></td>
                        <td><?= $row['alamat'] ?></td>
                        <td><?= $row['tgl_lahir'] ?></td>
                        <td><?= $row['jurusan'] ?></td>
                        <td><?= $row['semester'] ?></td>
                        <td>
                            <div class="linkButton">
                                <a href="edit-mahasiswa.php?nim=<?= $row['nim'] ?>">Edit</a>
                                <form action="" method="post">
                                    <input type="hidden" name="nim" value="<?= $row['nim'] ?>">
                                    <button type="submit">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php
                        $num++;
                            }
                        }else{
                    ?>
                    <tr>
                        <td colspan="8" style="text-align:center;">Tidak ada mahasiswa</td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>