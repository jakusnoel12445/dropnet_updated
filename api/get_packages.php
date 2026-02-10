
<?php

// Betöltjük az adatbázis kapcsolatot tartalmazó fájlt.
// A ../ azért kell, mert ez a fájl az "api" mappában van,
// a db.php pedig egy szinttel feljebb.
include '../db.php';


// Megmondjuk a böngészőnek, hogy JSON formátumú adatot küldünk vissza.
// Ez fontos, mert a JavaScript fetch így tudja megfelelően kezelni.
header('Content-Type: application/json');


// SQL lekérdezés futtatása.
// Csak az id, tracking_number és status mezőket kérjük le a packages táblából.
// Nem kérünk le minden mezőt, mert a PWA-nak most ennyi elég.
$result = $conn->query("SELECT id, tracking_number, status FROM packages");


// Létrehozunk egy üres tömböt.
// Ide fogjuk összegyűjteni az összes csomagot.
$packages = [];


// Végigmegyünk az összes lekérdezett soron.
// A fetch_assoc() egy sort ad vissza asszociatív tömbként
// pl: ["id" => 1, "tracking_number" => "ABC123", "status" => "felvéve"]
while($row = $result->fetch_assoc()){
    
    // A kapott sort hozzáadjuk a $packages tömbhöz
    $packages[] = $row;
}


// A PHP tömböt JSON formátumra alakítjuk,
// majd visszaküldjük a böngészőnek.
echo json_encode($packages);

?>
