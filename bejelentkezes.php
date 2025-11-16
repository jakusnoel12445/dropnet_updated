<?php
// --- Munkamenet indítása a bejelentkezéshez ---
session_start();

// --- Adatbázis kapcsolat betöltése ---
include 'db.php';

// --- Hibaváltozó előkészítése ---
$error = "";

// --- Ha elküldték az űrlapot (POST kérés) ---
if(isset($_POST['username']) && isset($_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    // --- Felhasználó keresése az adatbázisban ---
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        // --- Felhasználó megtalálva, jelszó ellenőrzés ---
        $user = $result->fetch_assoc();
        if(password_verify($password, $user['password'])){
            // --- Sikeres bejelentkezés, session mentése ---
            $_SESSION['user'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // --- Átirányítás az admin oldalra ---
            header("Location: admin.php");
            exit;
        } else {
            // --- Hibás jelszó ---
            $error = "Hibás jelszó";
        }
    } else {
        // --- Nincs ilyen felhasználó ---
        $error = "Nincs ilyen felhasználó";
    }
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bejelentkezés - DropNet</title>

  <!-- CSS stíluslapok csatolása -->
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="bejelentkezes.css" />
</head>
<body>
  <!-- Háttér -->
  <div class="background"></div>

  <!-- Vissza a főoldalra gomb -->
  <div class="back-button">
    <a href="index.php" class="btn">Vissza a főoldalra</a>
  </div>

  <!-- Bejelentkezési űrlap -->
  <div class="login-form">
    <h1>Bejelentkezés</h1>

    <!-- Bejelentkezés POST metódussal -->
    <form method="post">
      <input type="text" name="username" placeholder="Felhasználónév" required /> <!-- Felhasználónév mező -->
      <input type="password" name="password" placeholder="Jelszó" required /> <!-- Jelszó mező -->
      <button type="submit">Bejelentkezés</button> <!-- Beküldő gomb -->
    </form>

    <!-- Hibák megjelenítése -->
    <?php if($error != ""): ?>
      <p style="color:red; text-align:center;"><?php echo $error; ?></p>
    <?php endif; ?>
  </div>  
</body>
</html>
