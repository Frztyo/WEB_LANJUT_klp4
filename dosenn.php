<?php
include 'koneksi.php'; // Ensure this sets up a PDO connection: $pdo = new PDO(...);

$aksi = isset($_GET['aksi']) ? $_GET['aksi'] : 'list';

switch ($aksi) {
    case 'list':
?>
        <div class="row">
            <h2>Data Dosen</h2>
            <div class="col-2">
                <a href="index.php?p=dosen&aksi=input" class="btn btn-primary mb-3">Tambah Dosen</a>
            </div>

            <table class="table table-border">
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama Dosen</th>
                    <th>Email</th>
                    <th>Prodi</th>
                    <th>No Telepon</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>

                <?php
                try {
                    $stmt = $pdo->query("SELECT dosen.*, prodii.nama_prodi FROM prodii 
                                         INNER JOIN dosen ON prodii.id = dosen.prodi_id");
                    $no = 1;

                    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>
                                <td>{$no}</td>
                                <td>" . htmlspecialchars($data['nip']) . "</td>
                                <td>" . htmlspecialchars($data['nama_dosen']) . "</td>
                                <td>" . htmlspecialchars($data['email']) . "</td>
                                <td>" . htmlspecialchars($data['nama_prodi']) . "</td>
                                <td>" . htmlspecialchars($data['notelp']) . "</td>
                                <td>" . htmlspecialchars($data['alamat']) . "</td>
                                <td>
                                    <a href='index.php?p=dosen&aksi=edit&id={$data['id']}' class='btn btn-success'>Edit</a>
                                    <a href='proses_dosen.php?proses=delete&id={$data['id']}' class='btn btn-warning' onclick=\"return confirm('Yakin akan menghapus data?')\">Hapus</a>
                                </td>
                              </tr>";
                        $no++;
                    }
                } catch (PDOException $e) {
                    echo "<tr><td colspan='8'>Error: " . $e->getMessage() . "</td></tr>";
                }
                ?>
            </table>
        </div>
<?php
        break;

    case 'input':
?>
        <div class="row">
            <div class="col-6">
                <h2>Masukkan Data Dosen</h2>
                <a href="index.php?p=dosen" class="btn btn-primary mb-3">Data Dosen</a>
                <form action="proses_dosen.php?proses=insert" method="POST">
                    <div class="mb-3">
                        <label>NIP</label>
                        <input type="number" class="form-control" name="nip" required>
                    </div>
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama_dosen" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label>Program Studi</label>
                        <select name="prodi_id" class="form-select" required>
                            <option value="">--PILIH PRODI--</option>
                            <?php
                            try {
                                $stmt = $pdo->query("SELECT * FROM prodii");
                                while ($prodi = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<option value='{$prodi['id']}'>" . htmlspecialchars($prodi['nama_prodi']) . "</option>";
                                }
                            } catch (PDOException $e) {
                                echo "<option>Error: " . $e->getMessage() . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Nomor Telepon</label>
                        <input type="number" class="form-control" name="notelp" required>
                    </div>
                    <div class="mb-3">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger">Proses</button>
                    <button type="reset" class="btn btn-primary">Reset</button>
                </form>
            </div>
        </div>
<?php
        break;

    case 'edit':
        try {
            $stmt = $pdo->prepare("SELECT * FROM dosen WHERE id = ?");
            $stmt->execute([$_GET['id']]);
            $data_dosen = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$data_dosen) {
                echo "<p>Data tidak ditemukan.</p>";
                break;
            }
        } catch (PDOException $e) {
            echo "<p>Error: " . $e->getMessage() . "</p>";
            break;
        }
?>
        <div class="row">
            <div class="col-7">
                <h2>Edit Data Dosen</h2>
                <a href="index.php?p=dosen" class="btn btn-primary mb-3">Data Dosen</a>
                <form action="proses_dosen.php?proses=update" method="POST">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($data_dosen['id']) ?>">
                    <div class="mb-3">
                        <label>NIP</label>
                        <input type="text" class="form-control" name="nip" value="<?= htmlspecialchars($data_dosen['nip']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Nama Dosen</label>
                        <input type="text" class="form-control" name="nama_dosen" value="<?= htmlspecialchars($data_dosen['nama_dosen']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($data_dosen['email']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Program Studi</label>
                        <select name="prodi_id" class="form-select" required>
                            <option value="">--PILIH PRODI--</option>
                            <?php
                            $stmt = $pdo->query("SELECT * FROM prodii");
                            while ($prodi = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $selected = $prodi['id'] == $data_dosen['prodi_id'] ? 'selected' : '';
                                echo "<option value='{$prodi['id']}' $selected>" . htmlspecialchars($prodi['nama_prodi']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>No Telepon</label>
                        <input type="number" class="form-control" name="notelp" value="<?= htmlspecialchars($data_dosen['notelp']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control" required><?= htmlspecialchars($data_dosen['alamat']) ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger">Update</button>
                    <button type="reset" class="btn btn-primary">Reset</button>
                </form>
            </div>
        </div>
<?php
        break;
}
?>
