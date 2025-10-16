<?php
$nama_file = "siswa.json";

// --- Tambah Data Siswa Baru dari Form ---
if (isset($_POST['tambah'])) {
    $nama = trim($_POST['nama']);
    $umur = (int)$_POST['umur'];
    $kelas = trim($_POST['kelas']);
    $hobi = array_map('trim', explode(',', $_POST['hobi']));

    // Buat array siswa baru
    $siswa_baru = array(
        "nama" => $nama,
        "umur" => $umur,
        "kelas" => $kelas,
        "hobi" => $hobi
    );

    // Jika file sudah ada, ambil datanya dan tambahkan siswa baru
    if (file_exists($nama_file)) {
        $data_lama = json_decode(file_get_contents($nama_file), true);
    } else {
        $data_lama = [];
    }

    $data_lama[] = $siswa_baru;

    // Simpan kembali ke file JSON
    file_put_contents($nama_file, json_encode($data_lama, JSON_PRETTY_PRINT));
    echo "<p style='color:green;'>✅ Siswa baru berhasil ditambahkan!</p>";
}

// --- Hapus File JSON ---
if (isset($_POST['hapus'])) {
    if (file_exists($nama_file)) {
        unlink($nama_file);
        echo "<p style='color:red;'>🗑️ File JSON telah dihapus.</p>";
    }
}

// --- Data Awal (Jika file belum ada) ---
if (!file_exists($nama_file)) {
    $siswa_awal = array(
        array(
            "nama" => "Budi",
            "umur" => 17,
            "kelas" => "XI IPA 2",
            "hobi" => array("membaca", "berenang", "bermain gitar")
        )
    );
    file_put_contents($nama_file, json_encode($siswa_awal, JSON_PRETTY_PRINT));
}

// --- Tampilkan Isi File JSON ---
if (file_exists($nama_file)) {
    $data = json_decode(file_get_contents($nama_file), true);

    echo "<h2>📘 Data Siswa dalam JSON</h2>";
    echo "<pre style='background:#f4f4f4;padding:10px;border-radius:6px;'>";
    echo htmlspecialchars(file_get_contents($nama_file));
    echo "</pre>";

    echo "<h2>📋 Daftar Siswa:</h2>";
    echo "<table border='1' cellpadding='8' cellspacing='0' style='border-collapse:collapse;'>
            <tr style='background:#e0e0e0;'>
                <th>No</th>
                <th>Nama</th>
                <th>Umur</th>
                <th>Kelas</th>
                <th>Hobi</th>
            </tr>";

    $no = 1;
    foreach ($data as $siswa) {
        echo "<tr>
                <td>{$no}</td>
                <td>{$siswa['nama']}</td>
                <td>{$siswa['umur']}</td>
                <td>{$siswa['kelas']}</td>
                <td>" . implode(', ', $siswa['hobi']) . "</td>
              </tr>";
        $no++;
    }
    echo "</table>";
}
?>

<hr>
<h3>➕ Tambah Data Siswa Baru:</h3>
<form method="post">
    Nama: <input type="text" name="nama" required><br><br>
    Umur: <input type="number" name="umur" required><br><br>
    Kelas: <input type="text" name="kelas" required><br><br>
    Hobi (pisahkan dengan koma): <br>
    <textarea name="hobi" rows="2" cols="40" placeholder="contoh: membaca, bermain bola, menggambar" required></textarea><br><br>
    <button type="submit" name="tambah">Tambah Siswa</button>
</form>

<hr>
<h3>🗑️ Hapus File JSON:</h3>
<form method="post" onsubmit="return confirm('Yakin ingin menghapus semua data siswa?')">
    <button type="submit" name="hapus" style="color:white;background:red;padding:6px 12px;border:none;border-radius:4px;">Hapus File</button>
</form>
