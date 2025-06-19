<?php
// === Simpan data yang dikirim dari NodeMCU ===
if (isset($_GET['data'])) {
    $latestData = $_GET['data'];

    // Simpan ke file CSV
    $row = [date('Y-m-d H:i:s'), $latestData];
    $file = fopen("data.csv", "a");
    fputcsv($file, $row);
    fclose($file);

    exit(); // berhenti setelah menyimpan
}

// === Download data sebagai CSV ===
if (isset($_GET['download'])) {
    $file = "data.csv";
    if (file_exists($file)) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="riwayat_data.csv"');
        readfile($file);
        exit;
    } else {
        echo "File belum tersedia.";
        exit;
    }
}

// === Tampilkan data terbaru (baris terakhir CSV) ===
$filename = "data.csv";
if (file_exists($filename)) {
    $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $lastLine = end($lines);
    $data = str_getcsv($lastLine);
    echo $data[1]; // hanya kolom kedua (isi data dari NodeMCU)
} else {
    echo "Belum ada data.";
}
?>
