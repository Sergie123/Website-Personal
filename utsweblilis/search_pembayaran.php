<?php
include 'koneksi.php';

// Menangani permintaan pencarian
$start_date = '';
$end_date = '';
$result = null;

if (isset($_POST['search'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    // Mengambil data dari tabel pembayaran berdasarkan rentang tanggal
    $result = $conn->query("SELECT pembayaran.id_pembayaran, pembayaran.id_pasien, pembayaran.tanggal_bayar, pembayaran.total_biaya, pasien.nama_pasien 
                            FROM pembayaran 
                            INNER JOIN pasien ON pembayaran.id_pasien = pasien.id_pasien
                            WHERE pembayaran.tanggal_bayar BETWEEN '$start_date' AND '$end_date'");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Pembayaran</title>
    <link rel="stylesheet" type="text/css" href="pembayaran.css">
</head>
<body>
    <button onclick="window.location.href='dashboard.php'">Kembali ke Dashboard</button>
    <h2>Search Pembayaran</h2>
    <form method="post">
        Tanggal Mulai: <input type="date" name="start_date" value="<?php echo $start_date; ?>">
        Tanggal Akhir: <input type="date" name="end_date" value="<?php echo $end_date; ?>">
        <button type="submit" name="search">Search</button>
    </form>

    <?php if ($result !== null): ?>
        <h3 align="center">Daftar Pembayaran</h3>
        <table>
            <tr>
                <th>No</th>
                <th>Nama Pasien</th>
                <th>Tanggal Bayar</th>
                <th>Total Biaya</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id_pembayaran']; ?></td>
                        <td><?php echo $row['nama_pasien']; ?></td>
                        <td><?php echo $row['tanggal_bayar']; ?></td>
                        <td><?php echo $row['total_biaya']; ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No records found</td>
                </tr>
            <?php endif; ?>
        </table>
    <?php endif; ?>

    <script>
        function edit(id_pembayaran, id_pasien, tanggal_bayar, total_biaya) {
            document.getElementById('id_pembayaran').value = id_pembayaran;
            document.getElementById('id_pasien').value = id_pasien;
            document.getElementById('tanggal_bayar').value = tanggal_bayar;
            document.getElementById('total_biaya').value = total_biaya;
        }
    </script>
</body>
</html>
