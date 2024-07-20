<?php
include 'koneksi.php';

// Inisialisasi variabel untuk hasil pencarian
$search_id_pasien = '';
$search_date = '';
$search_results = null;

// Menangani permintaan pencarian
if (isset($_POST['search'])) {
    $search_id_pasien = $_POST['search_id_pasien'];
    $search_date = $_POST['search_date'];
    
    // Mengambil data pasien dan pembayaran berdasarkan ID pasien dan tanggal pembayaran
    if (!empty($search_id_pasien) && !empty($search_date)) {
        $search_results = $conn->query("SELECT pasien.id_pasien, pasien.nama_pasien, pasien.alamat, pasien.no_telpon, pembayaran.id_pembayaran, pembayaran.tanggal_bayar, pembayaran.total_biaya
                                        FROM pasien
                                        INNER JOIN pembayaran ON pasien.id_pasien = pembayaran.id_pasien
                                        WHERE pasien.id_pasien = $search_id_pasien AND pembayaran.tanggal_bayar = '$search_date'");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cari Data Pasien dan Pembayaran</title>
    <link rel="stylesheet" type="text/css" href="pembayaran.css">
</head>
<body>
    <button onclick="window.location.href='dashboard.php'">Kembali ke Dashboard</button>
    <h2>Cari Data Pasien dan Pembayaran</h2>
    
    <form method="post">
        <label for="search_id_pasien">ID Pasien:</label>
        <input type="text" name="search_id_pasien" id="search_id_pasien" value="<?php echo htmlspecialchars($search_id_pasien); ?>"><br>
        
        <label for="search_date">Tanggal Pembayaran:</label>
        <input type="date" name="search_date" id="search_date" value="<?php echo htmlspecialchars($search_date); ?>"><br>
        
        <button type="submit" name="search">Search</button>
    </form>

    <?php if ($search_results): ?>
        <h3 align="center">Daftar Pasien dan Pembayaran</h3>
        <table>
            <tr>
                <th>ID Pasien</th>
                <th>Nama Pasien</th>
                <th>Alamat</th>
                <th>No Telpon</th>
                <th>ID Pembayaran</th>
                <th>Tanggal Bayar</th>
                <th>Total Biaya</th>
            </tr>
            <?php if ($search_results->num_rows > 0): ?>
                <?php while ($row = $search_results->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id_pasien']); ?></td>
                        <td><?php echo htmlspecialchars($row['nama_pasien']); ?></td>
                        <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                        <td><?php echo htmlspecialchars($row['no_telpon']); ?></td>
                        <td><?php echo htmlspecialchars($row['id_pembayaran']); ?></td>
                        <td><?php echo htmlspecialchars($row['tanggal_bayar']); ?></td>
                        <td><?php echo htmlspecialchars($row['total_biaya']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">Tidak ada data yang ditemukan</td>
                </tr>
            <?php endif; ?>
        </table>
    <?php endif; ?>
</body>
</html>
