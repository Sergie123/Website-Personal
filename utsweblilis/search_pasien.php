<?php
include 'koneksi.php';

// Menangani permintaan pencarian
$search_keyword = '';
$result = null; // Inisialisasi $result dengan null

if (isset($_POST['search'])) {
    $search_keyword = $_POST['search_keyword'];
    // Mengambil data dari tabel pasien berdasarkan kata kunci pencarian
    $result = $conn->query("SELECT * FROM pasien WHERE nama_pasien LIKE '%$search_keyword%'");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Pasien</title>
    <link rel="stylesheet" type="text/css" href="pasien.css">
</head>
<body>
    <button onclick="window.location.href='dashboard.php'">Kembali ke Dashboard</button>
    <h2>Search Pasien</h2>
    <form method="post">
        Nama Pasien: <input type="text" name="search_keyword" value="<?php echo $search_keyword; ?>">
        <button type="submit" name="search">Search</button>
    </form>

    <?php if ($result !== null): ?>
        <h3 align="center">Daftar Pasien</h3>
        <table>
            <tr>
                <th>No</th>
                <th>Nama Pasien</th>
                <th>Alamat</th>
                <th>No Telpon</th>
            </tr>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id_pasien']; ?></td>
                        <td><?php echo $row['nama_pasien']; ?></td>
                        <td><?php echo $row['alamat']; ?></td>
                        <td><?php echo $row['no_telpon']; ?></td>
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
        function edit(id_pasien, nama_pasien, alamat, no_telpon) {
            document.getElementById('id_pasien').value = id_pasien;
            document.getElementById('nama_pasien').value = nama_pasien;
            document.getElementById('alamat').value = alamat;
            document.getElementById('no_telpon').value = no_telpon;
        }
    </script>
</body>
</html>
