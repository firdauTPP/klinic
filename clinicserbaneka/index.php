<?php
session_start();

// Jika belum login, alih ke login.php
if (!isset($_SESSION['login_user'])) {
    header("Location: login.php");
    exit();
}

// Sambungan ke database
$conn = new mysqli('localhost', 'root', '', 'maklumatpekerja');

// Semak sambungan
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data dari jadual pekerja
$sql = "SELECT id, nama, nokp, nohp, jantina FROM pekerja";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <title>Senarai Pekerja</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header .title {
            font-size: 24px;
        }

        .header .buttons button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            margin-left: 10px;
            cursor: pointer;
        }

        .header .buttons .add {
            background-color: #27ae60;
            color: white;
        }

        .header .buttons .logout {
            background-color: #e74c3c;
            color: white;
        }

        .container {
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #34495e;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .action-buttons button {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 5px;
        }

        .edit-btn {
            background-color: #3498db;
            color: white;
        }

        .delete-btn {
            background-color: #e74c3c;
            color: white;
        }

        /* Modal */
        #confirmModal {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 999;
        }

        #confirmModal .modal-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            width: 300px;
        }

        #confirmModal button {
            padding: 10px 20px;
            margin: 10px 5px 0;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #confirmDeleteBtn {
            background-color: #e74c3c;
            color: white;
        }

        .cancelBtn {
            background-color: #bdc3c7;
            color: black;
        }
    </style>
</head>
<body>

<div class="header">
    <div class="title">Senarai Maklumat Pekerja</div>
    <div class="buttons">
        <button class="add" onclick="location.href='create.php'">Tambah Pekerja</button>
        <button class="logout" onclick="location.href='logout.php'">Logout</button>
    </div>
</div>

<div class="container">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>No KP</th>
                <th>No HP</th>
                <th>Jantina</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['id']) ?></td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['nokp']) ?></td>
                        <td><?= htmlspecialchars($row['nohp']) ?></td>
                        <td><?= htmlspecialchars($row['jantina']) ?></td>
                        <td class="action-buttons">
                            <button class="edit-btn" onclick="location.href='edit.php?id=<?= $row['id'] ?>'">Edit</button>
                            <button class="delete-btn" onclick="confirmDelete(<?= $row['id'] ?>)">Padam</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="6">Tiada rekod dijumpai.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- MODAL PENGESAHAN PADAM -->
<div id="confirmModal">
    <div class="modal-content">
        <h3>Adakah anda pasti?</h3>
        <p>Sila pastikan dengan betul sebelum menghapuskan rekod ini.</p>
        <button id="confirmDeleteBtn">Yes, Delete</button>
        <button class="cancelBtn" onclick="closeModal()">Cancel</button>
    </div>
</div>

<script>
    let deleteId = null;

    function confirmDelete(id) {
        deleteId = id;
        document.getElementById('confirmModal').style.display = 'flex';
    }

    function closeModal() {
        deleteId = null;
        document.getElementById('confirmModal').style.display = 'none';
    }

    document.getElementById('confirmDeleteBtn').onclick = function () {
        if (deleteId !== null) {
            window.location.href = 'delete.php?id=' + deleteId;
        }
    };
</script>

</body>
</html>
