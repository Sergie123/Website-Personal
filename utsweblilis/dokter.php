<?php
include 'koneksi.php';

// Handle create request
if (isset($_POST['create'])) {
    $nama_dokter = $_POST['nama_dokter'];
    $spesialisasi = $_POST['spesialisasi'];
    $no_telpon = $_POST['no_telpon'];
    $conn->query("INSERT INTO dokter (nama_dokter, spesialisasi, no_telpon) VALUES ('$nama_dokter', '$spesialisasi', '$no_telpon')");
}

// Handle update request
if (isset($_POST['update'])) {
    $id_dokter = $_POST['id_dokter'];
    $nama_dokter = $_POST['nama_dokter'];
    $spesialisasi = $_POST['spesialisasi'];
    $no_telpon = $_POST['no_telpon'];
    $conn->query("UPDATE dokter SET nama_dokter='$nama_dokter', spesialisasi='$spesialisasi', no_telpon='$no_telpon' WHERE id_dokter=$id_dokter");
}

// Handle delete request
if (isset($_POST['delete'])) {
    $id_dokter = $_POST['id_dokter'];
    $conn->query("DELETE FROM dokter WHERE id_dokter=$id_dokter");
}

// Fetch data dari tabel Dokter
$result = $conn->query("SELECT * FROM dokter");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Dokter</title>
    <link rel="stylesheet" type="text/css" href="pasien.css">
</head>
<body>
    <button onclick="window.location.href='dashboard.php'">Kembali ke Dashboard</button>
    <h2>Manajemen Dokter</h2>
    <form method="post">
        <input type="hidden" name="id_dokter" id="id_dokter">
        Nama Dokter <input type="text" name="nama_dokter" id="nama_dokter"><br>
        Spesialisasi <input type="text" name="spesialisasi" id="spesialisasi"><br>
        No Telpon <input type="text" name="no_telpon" id="no_telpon"><br>
        <button type="submit" name="create">Create</button>
        <button type="submit" name="update">Update</button>
    </form>

    <h3 align="center">Daftar Dokter</h3>
    <table>
        <tr>
            <th>No</th>
            <th>Nama Dokter</th>
            <th>Spesialisasi</th>
            <th>No Telpon</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id_dokter']; ?></td>
                <td><?php echo $row['nama_dokter']; ?></td>
                <td><?php echo $row['spesialisasi']; ?></td>
                <td><?php echo $row['no_telpon']; ?></td>
                <td>
                    <button class='edit' onclick="edit(<?php echo $row['id_dokter']; ?>, '<?php echo $row['nama_dokter']; ?>', '<?php echo $row['spesialisasi']; ?>', '<?php echo $row['no_telpon']; ?>')">Edit</button>
                    <form method='post' style='display:inline;'>
                        <input type='hidden' name='id_dokter' value='<?php echo $row['id_dokter']; ?>'>
                        <button class='delete' type='submit' name='delete'>Delete</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <script>
        function edit(id_dokter, nama_dokter, spesialisasi, no_telpon) {
            document.getElementById('id_dokter').value = id_dokter;
            document.getElementById('nama_dokter').value = nama_dokter;
            document.getElementById('spesialisasi').value = spesialisasi;
            document.getElementById('no_telpon').value = no_telpon;
        }
    </script>
</body>
</html>