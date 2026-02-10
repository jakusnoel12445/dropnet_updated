<?php
// adatbázis kapcsolat
include 'db.php';

// csomagok lekérdezése
$result = $conn->query("SELECT id, tracking_number, status FROM packages");
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Csomag kezelés</title>
    <style>
        body {
            font-family: Arial;
            background: #1e1e2f;
            color: white;
            padding: 40px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #2b2b40;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #444;
            text-align: center;
        }

        th {
            background: #333355;
        }

        button {
            padding: 6px 10px;
            margin: 2px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
        }

        .btn1 { background: #3498db; }
        .btn2 { background: #f39c12; }
        .btn3 { background: #2ecc71; }
        .btn4 { background: #e74c3c; }

        button:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>

<h2>Csomag státusz kezelő</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Csomagszám</th>
        <th>Státusz</th>
        <th>Módosítás</th>
    </tr>

    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['tracking_number'] ?></td>
            <td id="status-<?= $row['id'] ?>">
                <?= $row['status'] ?>
            </td>
            <td>
                <button class="btn1" onclick="updateStatus(<?= $row['id'] ?>, 'felvéve')">Felvéve</button>
                <button class="btn2" onclick="updateStatus(<?= $row['id'] ?>, 'szallitas alatt')">Szállítás</button>
                <button class="btn3" onclick="updateStatus(<?= $row['id'] ?>, 'kiszallitva')">Kiszállítva</button>
                <button class="btn4" onclick="updateStatus(<?= $row['id'] ?>, 'hibas')">Hibás</button>
            </td>
        </tr>
    <?php endwhile; ?>

</table>

<script>
function updateStatus(id, status) {

    fetch("api/update_status.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            id: id,
            status: status
        })
    })
    .then(res => res.json())
    .then(data => {

        if(data.success){
            document.getElementById("status-" + id).innerText = status;
        } else {
            alert("Hiba történt: " + data.error);
        }

    });

}
</script>

</body>
</html>
