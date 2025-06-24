<?php
// Sambungan ke database
$conn = new mysqli('localhost', 'root', '', 'maklumatpekerja');

// Semak sambungan
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Jika borang dihantar
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $conn->real_escape_string($_POST['nama']);
    $nokp = $conn->real_escape_string($_POST['nokp']);
    $nohp = $conn->real_escape_string($_POST['nohp']);
    $jantina = $conn->real_escape_string($_POST['jantina']);

    $sql = "INSERT INTO pekerja (nama, nokp, nohp, jantina)
            VALUES ('$nama', '$nokp', '$nohp', '$jantina')";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php?msg=added");
        exit();
    } else {
        echo "Ralat: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pekerja</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f9;
            padding: 40px;
        }

        .form-container {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
        }

        label {
            font-weight: bold;
        }

        input, select, button {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            margin-bottom: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #27ae60;
            color: white;
            font-weight: bold;
            border: none;
        }

        button:hover {
            opacity: 0.9;
        }

        .back-btn {
            background-color: #34495e;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Tambah Pekerja Baharu</h2>
        <form method="POST" action="create.php">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" required>

            <label for="nokp">No KP:</label>
            <input type="text" id="nokp" name="nokp" required>

            <label for="nohp">No HP:</label>
            <input type="text" id="nohp" name="nohp" required>

            <label for="jantina">Jantina:</label>
            <select id="jantina" name="jantina" required>
                <option value="">-- Pilih Jantina --</option>
                <option value="Lelaki">Lelaki</option>
                <option value="Perempuan">Perempuan</option>
            </select>

            <button type="submit">Tambah Pekerja</button>
            <button type="button" class="back-btn" onclick="location.href='index.php'">Kembali</button>
        </form>
    </div>
</body>
</html>
