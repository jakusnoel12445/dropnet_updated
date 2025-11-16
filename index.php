<?php
// ---- Adatbázis kapcsolat betöltése ----
// Ezt a fájlt külön "db.php" néven kell létrehozni, és ott megadni a kapcsolatot (host, user, jelszó, adatbázis)
include 'db.php';

// ---- Alapértelmezett változók ----
// Ezeket később a lekérdezés után töltjük fel
$status = "";
$location = "";
$expected = "";

// ---- Ha a felhasználó beír egy csomagszámot és elküldi az űrlapot ----
if(isset($_POST['tracking_number'])){
    $tracking_number = $_POST['tracking_number'];

    // Lekérdezés az adatbázisból (packages tábla)
    $sql = "SELECT * FROM packages WHERE tracking_number='$tracking_number'";
    $result = $conn->query($sql);

    // Ha van találat → csomagadatok beolvasása
    if($result && $result->num_rows > 0){
        $package = $result->fetch_assoc();
        $status = $package['status'];
        $location = $package['location'];
        $expected = $package['expected_date'];
    } 
    // Ha nincs ilyen csomag
    else {
        $status = "Nincs ilyen csomag!";
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" /> <!-- Reszponzív nézet mobilon -->
  <title>DropNet</title> <!-- Böngésző fülön megjelenő cím -->
  <link rel="stylesheet" href="style.css" /> <!-- CSS stíluslap csatolása -->
</head>
<body>  

  <!-- Háttér elmosódott gömbökkel -->
  <div class="background">
    <span></span>
    <span></span>
    <span></span>
  </div>

  <!-- Fejléc (logo + menü gombok) -->
  <header class="header">
  <div class="logo-btn">
  <img src="logo.png" alt="DropNet logó" class="logo">
</div>
    <div class="button">
      <!-- Navigációs menü gombok -->
      <a href="elerhetosegeink.html" class="btn">Elérhetőségeink</a>
      <a href="rolunk.html" class="btn">Rólunk</a>
      <a href="bejelentkezes.php" class="btn">Bejelentkezés</a>
    </div>
  </header>

<!-- Bemutatkozó rész (hero szekció) -->
<section class="hero">
  <div class="hero-text">
    <h1>DropNet: Ahol minden csomag számít</h1>
    <h3>Biztonság, gyorsaság, átláthatóság, mindezt egy helyen.</h3>
    <hr>

    <div class="buttons">
      <a href="csomagolasu.html" class="btn">Csomagolási útmutató</a>
      <a href="#tracking" class="btn">Csomgpontjaink</a> <!--ÁT KELL ÍRNI MERT ITT ALAPBÓL  NEM EZ LENNE -->
    </div>

    <!-- Csomagkövető űrlap -->
    <form id="tracking" class="tracking-form" method="post" action="index.php">
      <input type="text" name="tracking_number" placeholder="Írd be a csomagszámot..." required />
      <button type="submit">Keresés</button>
    </form>

    <!-- PHP által megjelenített eredmény -->
    <?php if($status != ""): ?>
      <div class="tracking-result" style="margin-top:1rem; background:rgba(255,255,255,0.1); padding:0.75rem; border-radius:10px;">
        <p><strong>Státusz:</strong> <?php echo htmlspecialchars($status); ?></p>
        <?php if($location): ?><p><strong>Hely:</strong> <?php echo htmlspecialchars($location); ?></p><?php endif; ?>
        <?php if($expected): ?><p><strong>Várható érkezés:</strong> <?php echo htmlspecialchars($expected); ?></p><?php endif; ?>
      </div>
    <?php endif; ?>

    <!-- IDE kerülhet majd a nagy kép -->
    <!-- <img src="images/fooldal_kep.jpg" alt="DropNet csomag" class="hero-image"> -->
  </div>
</section>


  <!-- Szolgáltatások -->
  <section class="features">
    <div class="feature">
      <h3>⚲ Budapest lefedettség</h3>
      <p>Pest megyén belül a lehető leggyorsabb megoldás.</p>
    </div>
    <div class="feature">
      <h3>⏱︎ Villámgyors szállítás</h3>
      <p>Expressz opció 24–48 órán belül.</p>
    </div>
    <div class="feature">
      <h3>✓ Biztos kézbesítés</h3>
      <p>Minden csomag nyomon követhető és sértetlenül ér célba.</p>
    </div>
  </section>

  <!-- Árak -->
  <section class="arazas pricing-section">
    <h2>Budapesti csomagpont áraink</h2>
    <p class="intro">Csak saját DropNet csomagpontjainkra érvényes fix árak</p>

    <div class="pricing-grid">
      <!-- Egyes csomagméretek -->
      <div class="pkg-card">
        <div class="pkg-header"><h3>XS</h3><span class="tag">Kis</span></div>
        <div class="pkg-body">
          <p>Max méret: ≤ 35 cm</p>
          <p>Max súly: ≤ 2 kg</p>
        </div>
        <div class="pkg-footer"><span class="price">690 Ft</span></div>
      </div>

      <div class="pkg-card">
        <div class="pkg-header"><h3>S</h3><span class="tag">Kis-Medium</span></div>
        <div class="pkg-body">
          <p>Max méret: ≤ 50 cm</p>
          <p>Max súly: ≤ 5 kg</p>
        </div>
        <div class="pkg-footer"><span class="price">890 Ft</span></div>
      </div>

      <div class="pkg-card">
        <div class="pkg-header"><h3>M</h3><span class="tag">Közepes</span></div>
        <div class="pkg-body">
          <p>Max méret: ≤ 65 cm</p>
          <p>Max súly: ≤ 10 kg</p>
        </div>
        <div class="pkg-footer"><span class="price">1 290 Ft</span></div>
      </div>

      <div class="pkg-card">
        <div class="pkg-header"><h3>L</h3><span class="tag">Nagy</span></div>
        <div class="pkg-body">
          <p>Max méret: ≤ 80 cm</p>
          <p>Max súly: ≤ 20 kg</p>
        </div>
        <div class="pkg-footer"><span class="price">1 890 Ft</span></div>
      </div>

      <div class="pkg-card">
        <div class="pkg-header"><h3>XL</h3><span class="tag">Extra nagy</span></div>
        <div class="pkg-body">
          <p>Max méret: ≤ 120 cm</p>
          <p>Max súly: ≤ 30 kg</p>
        </div>
        <div class="pkg-footer"><span class="price">2 490 Ft</span></div>
      </div>

      <!-- Expressz szállítás -->
      <div class="pkg-card express">
        <div class="pkg-header"><h3>Express</h3><span class="tag">Pár órás</span></div>
        <div class="pkg-body">
          <p>XS–L kategóriákig</p>
          <p>Max súly: ≤ 10 kg</p>
        </div>
        <div class="pkg-footer"><span class="price">3 990 Ft</span></div>
      </div>
    </div>
  </section>

  <!-- Kapcsolat -->
  <section class="contact">
    <h2>Kapcsolat</h2>
    <form>
      <input type="text" placeholder="Név" /> <!-- placeholder: előre megjelenített szöveg, ami eltűnik, ha gépelni kezdünk -->
      <input type="email" placeholder="Email" />
      <textarea placeholder="Üzenet"></textarea>
      <button>Küldés</button>
    </form>
  </section>

  <!-- Lábléc -->
  <footer class="footer">
    <p>© 2025 DropNet</p>
    <div>
      <a href="adatvedelem.html">Adatvédelem</a>
      <a href="#">ÁSZF</a>
      <a href="#">Kapcsolat</a>
    </div>
  </footer>

</body>
</html>
