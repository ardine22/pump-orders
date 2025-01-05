<?php
// Koneksi ke database
$conn = new mysqli("localhost", "root", "", "pump_orders");

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Ambil semua pesanan dari database
$sql = "SELECT * FROM orders ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Penjual</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('background-nature.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 20px;
            color: #ffffff;
        }
        h2 {
            text-align: center;
            color: #ffffff;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(0, 0, 0, 0.7); /* Transparansi */
            margin: 20px 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: #ffffff;
        }
        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.1);
        }
        tr:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body>
    <h2>Dashboard Penjual</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Sumur</th>
                <th>Durasi (Jam)</th>
                <th>Catatan</th>
                <th>Total Harga (Rp)</th>
                <th>Waktu Pesanan</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['pump']); ?></td>
                    <td><?php echo $row['duration']; ?></td>
                    <td><?php echo htmlspecialchars($row['notes']) ?: 'Tidak ada'; ?></td>
                    <td>Rp<?php echo number_format($row['total_price'], 0, ',', '.'); ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>
