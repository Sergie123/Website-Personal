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
    <h2>Manajemen Obat</h2>
    <form method="post" action="">
        <input type="hidden" name="id_obat" id="id_obat">
        Nama Dokter:
        <select name="id_dokter" id="id_dokter">
            <?php
            // Ambil daftar dokter dari database
            $stmt_dokter = $conn->prepare("SELECT * FROM dokter");
            $stmt_dokter->execute();
            $dokter_result = $stmt_dokter->get_result();
            while ($dokter = $dokter_result->fetch_assoc()) {
                echo "<option value='{$dokter['id_dokter']}'>{$dokter['nama_dokter']}</option>";
            }
            ?>
        </select><br>
        Nama Obat <input type="text" name="nama_obat" id="nama_obat"><br>
        Jenis Obat <input type="text" name="jenis_obat" id="jenis_obat"><br>
        Harga Obat <input type="text" name="harga_obat" id="harga_obat"><br>
        <button type="submit" name="create">Create</button>
        <button type="submit" name="update">Update</button>
    </form>

    <h3 align="center">Daftar Obat</h3>
    <table>
        <tr>
            <th>Id Obat</th>
            <th>Nama Obat</th>
            <th>Jenis Obat</th>
            <th>Harga Obat</th>
            <th>Dokter</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id_obat']; ?></td>
                <td><?php echo htmlspecialchars($row['nama_obat']); ?></td>
                <td><?php echo htmlspecialchars($row['jenis_obat']); ?></td>
                <td><?php echo $row['harga_obat']; ?></td>
                <td><?php echo htmlspecialchars($row['nama_dokter']); ?></td>
                <td>
                    <button class='edit' onclick="edit(<?php echo $row['id_obat']; ?>, '<?php echo htmlspecialchars($row['nama_obat']); ?>', '<?php echo htmlspecialchars($row['jenis_obat']); ?>', '<?php echo $row['harga_obat']; ?>', <?php echo $row['id_dokter']; ?>)">Edit</button>
                    <form method='post' style='display:inline;'>
                        <input type='hidden' name='id_obat' value='<?php echo $row['id_obat']; ?>'>
                        <button class='delete' type='submit' name='delete'>Delete</button>
                    </form>
                </td>
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
