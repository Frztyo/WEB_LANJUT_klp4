<?php
include('koneksi.php'); // Pastikan file koneksi.php menggunakan PDO untuk koneksi ke database

if ($_GET['proses'] == 'insert') {
    if (isset($_POST['proses'])) {
        try {
            $sql = "INSERT INTO dosen (nip, nama_dosen, email, prodi_id, notelp, alamat) 
                    VALUES (:nip, :nama_dosen, :email, :prodi_id, :notelp, :alamat)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nip' => $_POST['nip'],
                ':nama_dosen' => $_POST['nama_dosen'],
                ':email' => $_POST['email'],
                ':prodi_id' => $_POST['prodi_id'],
                ':notelp' => $_POST['notelp'],
                ':alamat' => $_POST['alamat']
            ]);

            echo "<script>window.location='index.php?p=dosen'</script>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

if ($_GET['proses'] == 'update') {
    if (isset($_POST['proses'])) {
        try {
            $sql = "UPDATE dosen SET 
                    nip = :nip, 
                    nama_dosen = :nama_dosen, 
                    email = :email, 
                    prodi_id = :prodi_id, 
                    notelp = :notelp, 
                    alamat = :alamat 
                    WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':nip' => $_POST['nip'],
                ':nama_dosen' => $_POST['nama_dosen'],
                ':email' => $_POST['email'],
                ':prodi_id' => $_POST['prodi_id'],
                ':notelp' => $_POST['notelp'],
                ':alamat' => $_POST['alamat'],
                ':id' => $_POST['id']
            ]);

            echo "<script>window.location='index.php?p=dosen'</script>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

if ($_GET['proses'] == 'delete') {
    if (isset($_GET['id'])) {
        try {
            $sql = "DELETE FROM dosen WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $_GET['id']]);

            echo "<script>window.location='index.php?p=dosen'</script>";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
