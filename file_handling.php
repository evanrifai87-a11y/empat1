<?php
$nama_file = "catatan_siswa.txt";

// Jika tombol hapus ditekan
if (isset($_POST['hapus'])) {
    if (file_exists($nama_file)) {
        unlink($nama_file);
        echo "<p style='color:red;'>File berhasil dihapus!</p>";
    } else {
        echo "<p style='color:red;'>File tidak ditemukan!</p>";
    }
}

// Jika tombol tambah catatan ditekan
if (isset($_POST['tambah'])) {
    $catatan_baru = trim($_POST['catatan']);
    if (!empty($catatan_baru)) {
        $isi_tambah = "Catatan: " . $catatan_baru . "\nTanggal: " . date("Y-m-d H:i:s") . "\n\n";
        file_put_contents($nama_file, $isi_tambah, FILE_APPEND);
        echo "<p style='color:green;'>Catatan baru berhasil ditambahkan!</p>";
    }
}

// Membuat file jika belum ada
if (!file_exists($nama_file)) {
    file_put_contents($nama_file, "=== Catatan Siswa ===\n\n");
    echo "<p>File baru telah dibuat.</p>";
}

// Menampilkan isi file
echo "<h3>Isi File:</h3>";
$isi_file = file($nama_file); // baca per baris
if ($isi_file) {
    echo "<pre style='background:#f9f9f9;padding:10px;border:1px solid #ccc;border-radius:6px;'>";
    foreach ($isi_file as $nomor => $baris) {
        echo ($nomor + 1) . ". " . htmlspecialchars($baris);
    }
    echo "</pre>";
} else {
    echo "<p>File kosong atau tidak dapat dibaca.</p>";
}

// Menampilkan informasi file
if (file_exists($nama_file)) {
    echo "<h3>Informasi File:</h3>";
    echo "Ukuran file: " . filesize($nama_file) . " bytes<br>";
    echo "Terakhir diubah: " . date("Y-m-d H:i:s", filemtime($nama_file)) . "<br>";
    echo "Dibuat pada: " . date("Y-m-d H:i:s", filectime($nama_file)) . "<br>";
}
?>

<hr>
<h3>Tambah Catatan Baru:</h3>
<form method="post">
    <textarea name="catatan" rows="3" cols="50" placeholder="Tulis catatan baru di sini..."></textarea><br><br>
    <button type="submit" name="tambah">Tambah Catatan</button>
</form>

<hr>
<h3>Hapus File:</h3>
<form method="post" onsubmit="return confirm('Yakin ingin menghapus file ini?')">
    <button type="submit" name="hapus" style="color:white;background:red;padding:6px 12px;border:none;border-radius:4px;">Hapus File</button>
</form>
