<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="dashboard.css">
</head>
<body>
    <div class="container">
        <h2>Dashboard</h2>
        <p class="welcome-message">Welcome, <?php echo $_SESSION['username']; ?>!</p>
        <div class="links">
            <?php if ($_SESSION['role'] == 'admin'): ?>
                <a href="pasien.php" class="link-button">Kelola Data Pasien</a>
                <a href="obat.php" class="link-button">Kelola Data Obat</a>
                <a href="dokter.php" class="link-button">Kelola Data Dokter</a>
                <a href="pembayaran.php" class="link-button">Kelola Pembayaran</a>
                <a href="search_pasien.php" class="link-button">Informasi Data Pasien</a>
                <a href="informasi_pembayaran.php" class="link-button">Informasi Data Pembayaran</a>
                <a href="search_pembayaran.php" class="link-button">Informasi Data Perperiode</a>
                <a href="cari_data.php" class="link-button">Informasi Data perkode</a>
            <?php elseif ($_SESSION['role'] == 'pasien'): ?>
                <a href="pasien.php" class="link-button">Pendaftaran Pasien</a>
                <a href="lihatobat.php" class="link-button">Lihat Obat</a>
                <a href="pembayaran.php" class="link-button">Proses Pembayaran</a>
            <?php endif; ?>
        </div>
        <a href="logout.php" class="logout-button">Logout</a>
    </div>
</body>
</html>