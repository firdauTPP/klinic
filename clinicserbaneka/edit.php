<?php
// Sambungan ke database
$conn = new mysqli('localhost', 'root', '', 'maklumatpekerja');

// Semak sambungan
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pastikan ID diterima dari URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "ID tidak sah.";
    exit();
}

$id = intval($_GET['id']);

// Bila borang dihantar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $conn->real_escape_string($_POST['nama']);
    $nokp = $conn->real_escape_string($_POST['nokp']);
    $nohp = $conn->real_escape_string($_POST['nohp']);
    $jantina = $conn->real_escape_string($_POST['jantina']);

    $stmt = $conn->prepare("UPDATE pekerja SET nama=?, nokp=?, nohp=?, jantina=? WHERE id=?");
    $stmt->bind_param("ssssi", $nama, $nokp, $nohp, $jantina, $id);

    if ($stmt->execute()) {
        header("Location: index.php?msg=updated");
        exit();
    } else {
        echo "Gagal mengemas kini data.";
    }
}

// Ambil data pekerja untuk borang
$result = $conn->query("SELECT * FROM pekerja WHERE id = $id");
if ($result->num_rows === 0) {
    echo "Rekod tidak dijumpai.";
    exit();
}
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Edit Maklumat Pekerja</title>
    <style>
        body {
            font-family: Arial;
            background-color: #f4f4f9;
            padding: 20px;
        }

        .form-box {
            background: white;
            max-width: 500px;
            margin: auto;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input, select, button {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #27ae60;
            color: white;
            border: none;
            font-weight: bold;
            cursor: pointer;
        }

        button.cancel {
            background-color: #e74c3c;
            margin-top: -10px;
        }

        button:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="form-box">
        <h2>Edit Maklumat Pekerja</h2>
        <form method="POST">
            <label for="nama">Nama:</label>
            <input type="text" name="nama" id="nama" value="<?= htmlspecialchars($row['nama']) ?>" required>

            <label for="nokp">No Kad Pengenalan:</label>
            <input type="text" name="nokp" id="nokp" value="<?= htmlspecialchars($row['nokp']) ?>" required>

            <label for="nohp">No Telefon:</label>
            <input type="text" name="nohp" id="nohp" value="<?= htmlspecialchars($row['nohp']) ?>" required>

            <label for="jantina">Jantina:</label>
            <select name="jantina" id="jantina" required>
                <option value="Lelaki" <?= $row['jantina'] == 'Lelaki' ? 'selected' : '' ?>>Lelaki</option>
                <option value="Perempuan" <?= $row['jantina'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
            </select>

            <button type="submit">Simpan Perubahan</button>
            <button type="button" class="cancel" onclick="window.location.href='index.php'">Batal</button>
        </form>
    </div>
</body>
</html>
