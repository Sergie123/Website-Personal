<?php
include 'koneksi.php';

// Fetch data based on single date search
$search_date = '';
$result = null;

if (isset($_POST['search'])) {
    $search_date = $_POST['search_date'];
    $result = $conn->query("SELECT pembayaran.id_pembayaran, pembayaran.id_pasien, pembayaran.tanggal_bayar, pembayaran.total_biaya, pasien.nama_pasien 
                            FROM pembayaran 
                            INNER JOIN pasien ON pembayaran.id_pasien = pasien.id_pasien
                            WHERE pembayaran.tanggal_bayar = '$search_date'");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Informasi Pembayaran</title>
    <link rel="stylesheet" type="text/css" href="pembayaran.css">
</head>
<body>
    <button onclick="window.location.href='dashboard.php'">Kembali ke Dashboard</button>

    <h2>Search Pembayaran</h2>
    <form method="post">
        Tanggal: <input type="date" name="search_date" value="<?php echo $search_date; ?>">
        <button type="submit" name="search">Search</button>
    </form>

    <?php if ($result): ?>
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
                    <td colspan="4">No records found</td>
                </tr>
            <?php endif; ?>
        </table>
    <?php endif; ?>
</body>
</html>
