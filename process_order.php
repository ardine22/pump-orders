<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "pump_orders");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Validasi data input dari formulir
if (isset($_POST['pump']) && !empty($_POST['pump'])) {
    $pump = $_POST['pump'];
} else {
    die("Sumur belum dipilih. Silakan kembali dan pilih sumur.");
}

$name = $_POST['name'];
$duration = (int)$_POST['duration'];
$notes = isset($_POST['notes']) ? $_POST['notes'] : '';

// Tentukan harga berdasarkan sumur
if ($pump == "Sumur 1") {
    $price_per_hour = 30000;
} else {
    $price_per_hour = 50000;
}

// Hitung total harga
$total_price = $duration * $price_per_hour;

// Simpan pesanan ke database
$sql = "INSERT INTO orders (name, pump, duration, notes, total_price) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssisd", $name, $pump, $duration, $notes, $total_price);

if ($stmt->execute()) {
    echo "Pesanan berhasil dikirim!<br>";
    echo "Nama: " . htmlspecialchars($name) . "<br>";
    echo "Sumur: " . htmlspecialchars($pump) . "<br>";
    echo "Durasi: " . $duration . " jam<br>";
    echo "Total Harga: Rp" . number_format($total_price, 0, ',', '.') . "<br>";
    echo "<a href='order.html'>Pesan lagi</a>";
} else {
    echo "Terjadi kesalahan: " . $stmt->error;
}

// Tutup koneksi
$stmt->close();
$conn->close();
?>
