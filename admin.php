<?php
session_start();
include 'db.php';

if(!isset($_SESSION['user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Csomag státusz frissítés
if(isset($_POST['package_id'])){
    $id = (int)$_POST['package_id'];
    $status = trim($_POST['status']);
    $location = trim($_POST['location']);
    $expected = trim($_POST['expected']);

    // Státusz validálása
    $allowed_status = ['felvéve','szallitas alatt','kiszallitva'];
    if(!in_array($status, $allowed_status)){
        $status = 'felvéve'; // alapértelmezett érték, ha érvénytelen
    }

    // Adatbázis frissítés
    $stmt = $conn->prepare("UPDATE packages SET status = ?, location = ?, expected_date = ? WHERE id = ?");
    $stmt->bind_param("sssi", $status, $location, $expected, $id);
    $stmt->execute();
    $stmt->close();
}


// Csomagok lekérdezése
$packages = $conn->query("SELECT * FROM packages");
?>
<!DOCTYPE html>
<html lang="hu">
<head>
<meta charset="UTF-8">
<title>Admin felület</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="hero">
    <h1>Admin felület - <?php echo $_SESSION['user']; ?></h1>
    <a href="logout.php">Kijelentkezés</a>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID</th><th>Csomagszám</th><th>Státusz</th><th>Hely</th><th>Várható</th><th>Művelet</th>
        </tr>
        <?php while($row = $packages->fetch_assoc()): ?>
        <tr>
            <form method="post">
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['tracking_number']; ?></td>
                <td>
                    <select name="status">
                        <option value="felvéve" <?php if($row['status']=="felvéve") echo "selected";?>>Felvéve</option>
                        <option value="szallitas alatt" <?php if($row['status']=="szallitas alatt") echo "selected";?>>Szállítás alatt</option>
                        <option value="kiszallitva" <?php if($row['status']=="kiszallitva") echo "selected";?>>Kiszállítva</option>
                    </select>
                </td>
                <td><input type="text" name="location" value="<?php echo $row['location']; ?>"></td>
                <td><input type="date" name="expected" value="<?php echo $row['expected_date']; ?>"></td>
                <td>
                    <input type="hidden" name="package_id" value="<?php echo $row['id']; ?>">
                    <button type="submit">Mentés</button>
                </td>
            </form>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>
