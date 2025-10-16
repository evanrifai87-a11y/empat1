<?php
function bagi($pembilang, $penyebut) {
    // Validasi tipe data
    if (!is_numeric($pembilang) || !is_numeric($penyebut)) {
        throw new Exception("Input harus berupa angka.");
    }

    // Cek pembagi nol
    if ($penyebut == 0) {
        throw new Exception("Pembagian dengan nol tidak diperbolehkan.");
    }

    // Jika pembilang nol, hasil langsung nol
    if ($pembilang == 0) {
        return 0;
    }

    // Jika pembilang dan penyebut negatif, hasilnya positif
    if ($pembilang < 0 && $penyebut < 0) {
        return abs($pembilang) / abs($penyebut);
    }

    // Jika pembagian negatif, beri peringatan
    if (($pembilang < 0 && $penyebut > 0) || ($pembilang > 0 && $penyebut < 0)) {
        echo "<i>Warning: Hasil pembagian negatif.</i><br>";
    }

    return $pembilang / $penyebut;
}

// Fungsi untuk log error ke file
function logError($message) {
    $logfile = 'error_log.txt';
    $current = date('Y-m-d H:i:s') . " - " . $message . PHP_EOL;
    file_put_contents($logfile, $current, FILE_APPEND);
}

try {
    echo bagi(10, 2) . "<br>";          // 5
    echo bagi(0, 10) . "<br>";          // 0
    echo bagi(-10, -2) . "<br>";        // 5
    echo bagi(10, -2) . "<br>";         // Warning + -5
    echo bagi("abc", 2) . "<br>";       // Error
    echo bagi(10, 0);                   // Error
} catch (Exception $e) {
    echo "Terjadi kesalahan: " . $e->getMessage();
    logError($e->getMessage());
}
?>
