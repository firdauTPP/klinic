<?php
// Sambungan ke database
$conn = new mysqli('localhost', 'root', '', 'maklumatpekerja');

// Semak sambungan
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Semak jika ID diberikan melalui URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Sediakan dan jalankan query delete
    $stmt = $conn->prepare("DELETE FROM pekerja WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Berjaya padam, alih ke index dengan mesej
        header("Location: index.php?msg=deleted");
        exit();
    } else {
        echo "Gagal memadam rekod.";
    }

    $stmt->close();
} else {
    echo "ID tidak sah.";
}

$conn->close();
?>
