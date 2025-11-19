<?php
// BUKA DI BROWSER: http://localhost/projek-pustaka/hash_generator.php
// ganti "passwordku" sesuai password admin / user yang ingin di-hash

$password = "admin123"; // ← SENPAI UBAH BAGIAN INI
$hash = password_hash($password, PASSWORD_DEFAULT);

echo "<h3>Password Asli:</h3>" . $password;
echo "<h3>HASH PASSWORD:</h3>" . $hash;

echo "<p>Copy hash tersebut dan simpan ke kolom 'password' di database.</p>";
?>
