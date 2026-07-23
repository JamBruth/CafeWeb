<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #121212; color: #fff; padding: 50px; text-align: center; }
        .dashboard { max-width: 600px; margin: auto; background: #1e1e1e; padding: 40px; border-radius: 8px; border: 1px solid #00ff00; }
        .flag { background: #2d2d2d; color: #00ff00; padding: 15px; font-family: monospace; font-size: 18px; margin: 20px 0; border: 1px dashed #00ff00; }
        a { color: #ff4444; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <div class="dashboard">
        <h1>Selamat Datang di Panel Admin!</h1>
        <p>Anda berhasil masuk sebagai: <strong><?php echo htmlspecialchars($_SESSION['admin']); ?></strong></p>
        
        <div class="flag">
            FLAG{SQLi_bypassed_successfully_2026}
        </div>

        <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>