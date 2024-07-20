<?php
include 'koneksi.php';

// Handle create request
if (isset($_POST['create'])) {
    $nama_pasien = $_POST['nama_pasien'];
    $alamat = $_POST['alamat'];
    $no_telpon = $_POST['no_telpon'];
    $conn->query("INSERT INTO pasien (nama_pasien, alamat, no_telpon) VALUES ('$nama_pasien', '$alamat', '$no_telpon')");
}

// Handle update request
if (isset($_POST['update'])) {
    $id_pasien = $_POST['id_pasien'];
    $nama_pasien = $_POST['nama_pasien'];
    $alamat = $_POST['alamat'];
    $no_telpon = $_POST['no_telpon'];
    $conn->query("UPDATE pasien SET nama_pasien='$nama_pasien', alamat='$alamat', no_telpon='$no_telpon' WHERE id_pasien=$id_pasien");
}

// Handle delete request
if (isset($_POST['delete'])) {
    $id_pasien = $_POST['id_pasien'];
    $conn->query("DELETE FROM pasien WHERE id_pasien=$id_pasien");
}

// Fetch data dari tabel Pasien
$result = $conn->query("SELECT * FROM pasien");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manajemen Pasien</title>
    <link rel="stylesheet" type="text/css" href="pasien.css">
</head>
<body>
    <button onclick="window.location.href='dashboard.php'">Kembali ke Dashboard</button>
    <h2>Manajemen Pasien</h2>
    <form method="post">
        <input type="hidden" name="id_pasien" id="id_pasien">
        Nama Pasien <input type="text" name="nama_pasien" id="nama_pasien"><br>
        Alamat <input type="text" name="alamat" id="alamat"><br>
        No Telpon <input type="text" name="no_telpon" id="no_telpon"><br>
        <button type="submit" name="create">Create</button>
        <button type="submit" name="update">Update</button>
    </form>

    <h3 align="center">Daftar Pasien</h3>
    <table>
        <tr>
            <th>No</th>
            <th>Nama Pasien</th>
            <th>Alamat</th>
            <th>No Telpon</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id_pasien']; ?></td>
                <td><?php echo $row['nama_pasien']; ?></td>
                <td><?php echo $row['alamat']; ?></td>
                <td><?php echo $row['no_telpon']; ?></td>
                <td>
                    <button class='edit' onclick="edit(<?php echo $row['id_pasien']; ?>, '<?php echo $row['nama_pasien']; ?>', '<?php echo $row['alamat']; ?>', '<?php echo $row['no_telpon']; ?>')">Edit</button>
                    <form method='post' style='display:inline;'>
                        <input type='hidden' name='id_pasien' value='<?php echo $row['id_pasien']; ?>'>
                        <button class='delete' type='submit' name='delete'>Delete</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

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