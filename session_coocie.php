<?php
session_start();

// === LOGOUT ===
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    setcookie("last_visit", "", time() - 3600); // hapus cookie
    echo "<p style='color:red;'>Anda telah logout. Silakan login kembali.</p>";
}

// === LOGIN (SET SESSION) ===
if (isset($_POST['login'])) {
    $nama = trim($_POST['nama']);
    if (!empty($nama)) {
        $_SESSION['nama_user'] = $nama;
        $_SESSION['waktu_login'] = date("Y-m-d H:i:s");
        setcookie("last_visit", date("Y-m-d H:i:s"), time() + (86400 * 3)); // berlaku 3 hari
        echo "<p style='color:green;'>Selamat datang, $nama! Sesi dan cookie telah diatur.</p>";
    }
}

// === TAMPILAN SETELAH LOGIN ===
if (isset($_SESSION['nama_user'])) {
    $nama_user = $_SESSION['nama_user'];
    $waktu_login = $_SESSION['waktu_login'];

    echo "<h2>Halo, $nama_user 👋</h2>";
    echo "<p>Anda login pada: <b>$waktu_login</b></p>";

    // Hitung durasi login
    $durasi = time() - strtotime($waktu_login);
    $menit = floor($durasi / 60);
    $detik = $durasi % 60;
    echo "<p>Anda sudah aktif selama: <b>$menit menit $detik detik</b></p>";

    // Menampilkan cookie
    echo "<h3>Data Cookie:</h3>";
    if (isset($_COOKIE['last_visit'])) {
        echo "<p>Kunjungan terakhir Anda sebelumnya: <b>" . $_COOKIE['last_visit'] . "</b></p>";
    } else {
        echo "<p>Ini adalah kunjungan pertama Anda.</p>";
    }

    // Tombol logout
    echo "
    <form method='post'>
        <button type='submit' name='logout' style='background:red;color:white;padding:6px 12px;border:none;border-radius:4px;'>Logout</button>
    </form>";

} else {
    // === FORM LOGIN ===
    echo "
    <h2>Login Sederhana</h2>
    <form method='post' style='background:#f4f4f4;padding:15px;border-radius:8px;width:300px;'>
        <label>Masukkan Nama:</label><br>
        <input type='text' name='nama' required style='width:100%;padding:6px;margin-top:5px;'><br><br>
        <button type='submit' name='login' style='background:blue;color:white;padding:6px 12px;border:none;border-radius:4px;'>Login</button>
    </form>";
}
?>
