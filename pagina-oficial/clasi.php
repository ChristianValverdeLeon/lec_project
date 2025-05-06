<?php
session_start();
$loggedIn = isset($_SESSION['user_id']);
require_once 'config/db.php'; // Conexión a la BD
// Generar puntos aleatorios y actualizar clasificación
$equipos = $pdo->query("SELECT team_id FROM classification WHERE year_season = 2025")->fetchAll(PDO::FETCH_ASSOC);

foreach ($equipos as $eq) {
    $randomPoints = rand(0, 30);
    $randomWins = rand(0, $randomPoints);
    $randomLosses = rand(0, 15);

    $update = $pdo->prepare("UPDATE classification SET points = ?, matches_won = ?, matches_lost = ? WHERE team_id = ?");
    $update->execute([$randomPoints, $randomWins, $randomLosses, $eq['team_id']]);
}

// Actualizar posición según puntos (mayor a menor)
$ranking = $pdo->query("SELECT team_id FROM classification WHERE year_season = 2025 ORDER BY points DESC")->fetchAll(PDO::FETCH_ASSOC);
$pos = 1;
foreach ($ranking as $row) {
    $pdo->prepare("UPDATE classification SET position = ? WHERE team_id = ?")->execute([$pos++, $row['team_id']]);
}

// Consulta para obtener la clasificación ordenada por posición
$sql = "SELECT team_id, team_name, position, matches_won, matches_lost, points, logo_url
        FROM classification
        ORDER BY position ASC";
$stmt = $pdo->query($sql);
$standings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<!-- favicon -->
<link rel="icon" href="/lol.ico" type="image/x-icon">
<link rel="shortcut icon" href="/lol.ico" type="image/x-icon">

  <meta charset="UTF-8">
  <title data-es="Clasificación - RIFTY FantasyLoL" data-en="Standings - RIFTY FantasyLoL">Clasificación - RIFTY FantasyLoL</title>
  <style>
    /* RESET Y TIPOGRAFÍA */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    html, body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #fafafa;
      color: #555;
      transition: background-color 0.3s, color 0.3s;
      height: 100%; /* Agregado para que flex funcione */
    }
    body.dark-mode {
      background-color: #1f1f1f;
      color: #eee;
    }
    /* Configuración flex para que el footer quede al final */
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    /* Wrapper para el contenido principal (sin modificar el .container existente) */
    .wrapper {
      flex: 1;
    }
    /* NAVBAR */
    nav {
      background-color: #222;
      padding: 15px;
      position: sticky;
      top: 0;
      z-index: 1000;
    }
    nav ul {
      list-style: none;
      display: flex;
      justify-content: space-between;
      align-items: center;
      max-width: 1200px;
      margin: 0 auto;
    }
    nav li {
      margin-right: 20px;
    }
    nav a {
      color: #fff;
      text-decoration: none;
      font-weight: bold;
      transition: color 0.3s;
    }
    nav a:hover {
      color: #f39c12;
    }
    .navbar-right {
      display: flex;
      gap: 10px;
    }
    .mode-toggle, .lang-toggle {
      background: #f39c12;
      color: #fff;
      border: none;
      padding: 8px 12px;
      border-radius: 4px;
      cursor: pointer;
      font-weight: bold;
      transition: background 0.3s;
    }
    .mode-toggle:hover, .lang-toggle:hover {
      background: #d98200;
    }
    /* CONTENEDOR PRINCIPAL */
    .container {
      width: 90%;
      max-width: 1100px;
      margin: 20px auto;
      padding-bottom: 30px;
    }
    h1 {
      text-align: center;
      margin-bottom: 20px;
      color: #2c3e50;
      font-size: 2rem;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    /* TABLA DE CLASIFICACIÓN */
    .standings-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    .standings-table th,
    .standings-table td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: center;
    }
    .standings-table th {
      background-color: #e74c3c;
      color: #fff;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    .team-logo {
      width: 40px;
      height: 40px;
      object-fit: cover;
      border-radius: 50%;
    }
    /* BOTÓN AL FINAL */
    .footer-btn {
      display: inline-block;
      background: #3498db;
      color: #fff;
      padding: 10px 15px;
      text-decoration: none;
      border-radius: 4px;
      font-weight: bold;
      transition: background 0.3s;
      margin-top: 20px;
    }
    .footer-btn:hover {
      background: #2980b9;
    }
    /* FOOTER */
    footer {
      text-align: center;
      padding: 15px;
      background-color: #222;
      color: #bbb;
      /* Se elimina margin-top extra */
    }
  </style>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const body = document.body;
      const modeToggle = document.getElementById('modeToggle');
      const langToggle = document.getElementById('langToggle');

      modeToggle.addEventListener('click', () => {
        body.classList.toggle('dark-mode');
      });

      let currentLang = 'es';
      langToggle.addEventListener('click', () => {
        currentLang = (currentLang === 'es') ? 'en' : 'es';
        translatePage(currentLang);
      });
      function translatePage(lang) {
        document.querySelectorAll('[data-es],[data-en]').forEach(el => {
          el.textContent = el.getAttribute(`data-${lang}`) || '';
        });
      }
    });
  </script>
</head>
<body>
  <!-- NAVBAR -->
  <nav>
    <ul>
      <li><a href="index.php" data-es="Inicio" data-en="Home">Inicio</a></li>
      <li><a href="jugadores.php" data-es="Jugadores" data-en="Players">Jugadores</a></li>
      <li><a href="clasi.php" data-es="Clasificación" data-en="Standings">Clasificación</a></li>
      <li><a href="reglas.php" data-es="Reglas" data-en="Rules">Reglas</a></li>

      <li class="navbar-right">
        <button id="modeToggle" class="mode-toggle" data-es="Modo Oscuro" data-en="Dark Mode">Modo Oscuro</button>
        <button id="langToggle" class="lang-toggle" data-es="EN/ES" data-en="EN/ES">EN/ES</button>
      </li>
<?php if ($loggedIn): ?>
  <li style="color: white; font-weight: bold; display: flex; align-items: center;">
    <span style="margin-right: 8px;">👤 <?php echo htmlspecialchars($_SESSION['username']); ?></span>
    <a href="logout.php" style="margin-left: 10px;" data-es="Logout" data-en="Logout">Logout</a>
  </li>
<?php else: ?>
        <li style="position: relative;"><a href="login.php" data-es="Login" data-en="Login">Login</a></li>
        <li style="position: relative;"><a href="register.php" data-es="Register" data-en="Register">Register</a></li>
      <?php endif; ?>
    </ul>
  </nav>

  <!-- WRAPPER para el contenido principal -->
  <div class="wrapper">
    <!-- CONTENEDOR PRINCIPAL -->
    <div class="container">
      <h1 data-es="Clasificación" data-en="Standings">Clasificación</h1>
      <p class="lead" data-es="Consulta la posición actual de los equipos en la liga." data-en="Check the current standings of the teams.">
        Consulta la posición actual de los equipos en la liga.
      </p>
      <!-- TABLA DE CLASIFICACIÓN -->
      <table class="standings-table">
        <thead>
          <tr>
            <th data-es="Posición" data-en="Position">Posición</th>
            <th data-es="Equipo" data-en="Team">Equipo</th>
            <th data-es="Partidos Ganados" data-en="Wins">Partidos Ganados</th>
            <th data-es="Partidos Perdidos" data-en="Losses">Partidos Perdidos</th>
            <th data-es="Puntos" data-en="Points">Puntos</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($standings as $team): ?>
            <tr>
              <td><?php echo htmlspecialchars($team['position']); ?></td>
              <td>
                <?php if (!empty($team['logo_url'])): ?>
                  <img src="<?php echo htmlspecialchars($team['logo_url']); ?>" alt="<?php echo htmlspecialchars($team['team_name']); ?>" class="team-logo">
                <?php endif; ?>
                <?php echo htmlspecialchars($team['team_name']); ?>
              </td>
              <td><?php echo htmlspecialchars($team['matches_won']); ?></td>
              <td><?php echo htmlspecialchars($team['matches_lost']); ?></td>
              <td><?php echo htmlspecialchars($team['points']); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <div class="text-center mt-20">
      </div>
    </div>
  </div>

  <!-- FOOTER -->
  <footer>
    <p>&copy; 2025 RIFTY - LEC. Todos los derechos reservados.</p>
  </footer>
</body>
</html>
