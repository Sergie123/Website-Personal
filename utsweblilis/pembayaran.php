<?php
include 'koneksi.php';

// Handle create request
if (isset($_POST['create'])) {
    $id_pasien = $_POST['id_pasien'];
    $tanggal_bayar = $_POST['tanggal_bayar'];
    $total_biaya = $_POST['total_biaya'];
    $conn->query("INSERT INTO pembayaran (id_pasien, tanggal_bayar, total_biaya) VALUES ($id_pasien, '$tanggal_bayar', $total_biaya)");
}

// Handle update request
if (isset($_POST['update'])) {
    $id_pembayaran = $_POST['id_pembayaran'];
    $id_pasien = $_POST['id_pasien'];
    $tanggal_bayar = $_POST['tanggal_bayar'];
    $total_biaya = $_POST['total_biaya'];
    $conn->query("UPDATE pembayaran SET id_pasien=$id_pasien, tanggal_bayar='$tanggal_bayar', total_biaya=$total_biaya WHERE id_pembayaran=$id_pembayaran");
}

// Handle delete request
if (isset($_POST['delete'])) {
    $id_pembayaran = $_POST['id_pembayaran'];
    $conn->query("DELETE FROM pembayaran WHERE id_pembayaran=$id_pembayaran");
}

// Fetch data dari tabel Pembayaran dengan join ke Pasien untuk mendapatkan nama pasien
$result = $conn->query("SELECT pembayaran.id_pembayaran, pembayaran.id_pasien, pembayaran.tanggal_bayar, pembayaran.total_biaya, pasien.nama_pasien 
                        FROM pembayaran 
                        INNER JOIN pasien ON pembayaran.id_pasien = pasien.id_pasien");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Proses Pembayaran</title>
    <link rel="stylesheet" type="text/css" href="pembayaran.css">
</head>
<body>
    <button onclick="window.location.href='dashboard.php'">Kembali ke Dashboard</button>
    <h2>Proses Pembayaran</h2>
    <form method="post">
        <input type="hidden" name="id_pembayaran" id="id_pembayaran">
        Nama Pasien:
        <select name="id_pasien" id="id_pasien">
            <?php
            // Ambil daftar pasien dari database
            $pasien_result = $conn->query("SELECT * FROM pasien");
            while ($pasien = $pasien_result->fetch_assoc()) {
                $selected = ($pasien['id_pasien'] == $row['id_pasien']) ? 'selected' : '';
                echo "<option value='{$pasien['id_pasien']}' $selected>{$pasien['nama_pasien']}</option>";
            }
            ?>
        </select><br>
        Tanggal Bayar <input type="date" name="tanggal_bayar" id="tanggal_bayar"><br>
        Total Biaya <input type="text" name="total_biaya" id="total_biaya"><br>
        <button type="submit" name="create">Create</button>
        <button type="submit" name="update">Update</button>
    </form>

    <h3 align="center">Daftar Pembayaran</h3>
    <table>
        <tr>
            <th>No</th>
            <th>Nama Pasien</th>
            <th>Tanggal Bayar</th>
            <th>Total Biaya</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id_pembayaran']; ?></td>
                <td><?php echo $row['nama_pasien']; ?></td>
                <td><?php echo $row['tanggal_bayar']; ?></td>
                <td><?php echo $row['total_biaya']; ?></td>
                <td>
                    <button class='edit' onclick="edit(<?php echo $row['id_pembayaran']; ?>, <?php echo $row['id_pasien']; ?>, '<?php echo $row['tanggal_bayar']; ?>', '<?php echo $row['total_biaya']; ?>')">Edit</button>
                    <form method='post' style='display:inline;'>
                        <input type='hidden' name='id_pembayaran' value='<?php echo $row['id_pembayaran']; ?>'>
                        <button class='delete' type='submit' name='delete'>Delete</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

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