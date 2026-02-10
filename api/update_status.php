<?php
include '../db.php';

header('Content-Type: application/json');

// Ezt a php://input segítségével tudjuk kiolvasni,
// majd json_decode-dal PHP tömbbé alakítjuk.
$data = json_decode(file_get_contents("php://input"), true);


// Ellenőrizzük, hogy megérkezett-e az id és a status.
// Ha valamelyik hiányzik, hibát küldünk vissza.
if(!isset($data['id']) || !isset($data['status'])){
    echo json_encode(["success" => false, "error" => "Hiányzó adat"]);
    exit;
}


// Az id-t számmá alakítjuk biztonság miatt.
$id = (int)$data['id'];

// A státuszt eltároljuk egy változóba.
$status = $data['status'];


// Megengedett státuszok listája.
// Csak ezekre lehet módosítani.
$allowed_status = ['felvéve','szallitas alatt','kiszallitva','hibas'];


// Ha a kapott státusz nincs a megengedettek között,
// akkor nem frissítünk.
if(!in_array($status, $allowed_status)){
    echo json_encode(["success" => false, "error" => "Érvénytelen státusz"]);
    exit;
}


// Prepared statement használata biztonság miatt.
// Ez megakadályozza az SQL injection támadást.
$stmt = $conn->prepare("UPDATE packages SET status = ? WHERE id = ?");


// A bind_param összeköti a változókat az SQL kérdéssel.
// "si" jelentése:
// s = string (status)
// i = integer (id)
$stmt->bind_param("si", $status, $id);


// Lekérdezés végrehajtása.
$stmt->execute();


// Statement lezárása.
$stmt->close();


// Sikeres válasz küldése JSON formában.
echo json_encode(["success" => true]);

?>
