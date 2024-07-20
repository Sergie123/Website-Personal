<?php
include 'koneksi.php';

// Handle create request
if (isset($_POST['create'])) {
    $id_dokter = $_POST['id_dokter'];
    $nama_obat = $_POST['nama_obat'];
    $jenis_obat = $_POST['jenis_obat'];
    $harga_obat = $_POST['harga_obat'];
    
    // Prepared statement untuk insert
    $stmt = $conn->prepare("INSERT INTO obat (id_dokter, nama_obat, jenis_obat, harga_obat) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issi", $id_dokter, $nama_obat, $jenis_obat, $harga_obat);
    $stmt->execute();
    $stmt->close();
}

// Handle update request
if (isset($_POST['update'])) {
    $id_obat = $_POST['id_obat'];
    $id_dokter = $_POST['id_dokter'];
    $nama_obat = $_POST['nama_obat'];
    $jenis_obat = $_POST['jenis_obat'];
    $harga_obat = $_POST['harga_obat'];
    
    // Prepared statement untuk update
    $stmt = $conn->prepare("UPDATE obat SET id_dokter=?, nama_obat=?, jenis_obat=?, harga_obat=? WHERE id_obat=?");
    $stmt->bind_param("issii", $id_dokter, $nama_obat, $jenis_obat, $harga_obat, $id_obat);
    $stmt->execute();
    $stmt->close();
}

// Handle delete request
if (isset($_POST['delete'])) {
    $id_obat = $_POST['id_obat'];
    $conn->query("DELETE FROM obat WHERE id_obat=$id_obat");
}

// Fetch data dari tabel Obat dengan join ke Dokter untuk mendapatkan nama dokter
$stmt = $conn->prepare("SELECT obat.id_obat, obat.nama_obat, obat.jenis_obat, obat.harga_obat, dokter.nama_dokter, obat.id_dokter 
                        FROM obat 
                        INNER JOIN dokter ON obat.id_dokter = dokter.id_dokter");
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Obat</title>
    <link rel="stylesheet" type="text/css" href="pembayaran.css">
</head>
<body>
    <button onclick="window.location.href='dashboard.php'">Kembali ke Dashboard</button>
    <h3 align="center">Daftar Obat</h3>
    <table>
        <tr>
            <th>Id Obat</th>
            <th>Nama Obat</th>
            <th>Jenis Obat</th>
            <th>Harga Obat</th>
            <th>Dokter</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id_obat']; ?></td>
                <td><?php echo htmlspecialchars($row['nama_obat']); ?></td>
                <td><?php echo htmlspecialchars($row['jenis_obat']); ?></td>
                <td><?php echo $row['harga_obat']; ?></td>
                <td><?php echo htmlspecialchars($row['nama_dokter']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <script>
        function edit(id_obat, nama_obat, jenis_obat, harga_obat, id_dokter) {
            document.getElementById('id_obat').value = id_obat;
            document.getElementById('id_dokter').value = id_dokter;
            document.getElementById('nama_obat').value = nama_obat;
            document.getElementById('jenis_obat').value = jenis_obat;
            document.getElementById('harga_obat').value = harga_obat;
        }
    </script>
</body>
</html>