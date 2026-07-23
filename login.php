<?php
session_start();
$message = "";

// Koneksi Database SQLite (Otomatis dibuat dalam satu file)
try {
    $db = new PDO('sqlite:database.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Buat tabel users jika belum ada & masukkan data default
    $db->exec("CREATE TABLE IF NOT EXISTS users (id INTEGER PRIMARY KEY, username TEXT, password TEXT);");
    $stmt = $db->query("SELECT COUNT(*) FROM users");
    if ($stmt->fetchColumn() == 0) {
        $db->exec("INSERT INTO users (username, password) VALUES ('admin', 'admin123');");
    }
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // VULNERABILITY: Sengaja menggunakan string concatenation yang rentan SQL Injection
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    
    try {
        $result = $db->query($query);
        $user = $result->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['admin'] = $user['username'];
            header("Location: admin.php");
            exit();
        } else {
            $message = "Login gagal! Username atau password salah.";
        }
    } catch (PDOException $e) {
        // Menampilkan error database untuk membantu proses pengujian (Information Disclosure)
        $message = "SQL Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - Security Test</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #121212; color: #fff; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: #1e1e1e; padding: 30px; border-radius: 8px; width: 300px; box-shadow: 0 0 10px rgba(0,0,0,0.5); }
        input { width: 100%; padding: 10px; margin: 10px 0; background: #2d2d2d; border: 1px solid #444; color: #fff; border-radius: 4px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #00ff00; border: none; font-weight: bold; cursor: pointer; border-radius: 4px; color: #000; }
        button:hover { background: #00cc00; }
        .error { color: #ff4444; font-size: 13px; margin-bottom: 10px; }
        a { color: #aaa; font-size: 12px; display: block; margin-top: 15px; text-align: center; text-decoration: none; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2 style="text-align: center; color: #00ff00;">Admin Login</h2>
        <?php if($message != "") { echo "<div class='error'>$message</div>"; } ?>
        <form method="POST" action="">
            <label>Username:</label>
            <input type="text" name="username" required>
            <label>Password:</label>
            <input type="password" name="password" required>
            <button type="submit">Login</button>
        </form>
        <a href="index.php">&larr; Kembali ke Beranda</a>
    </div>
</body>
</html>