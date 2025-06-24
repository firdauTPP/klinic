<?php
session_start();              // Mula sesi
session_unset();              // Kosongkan semua data dalam $_SESSION
session_destroy();            // Hapuskan sesi sepenuhnya

// Alihkan ke login dengan mesej log keluar
header("Location: login.php?logout=1");
exit();
?>
