<?php
session_start();
$loggedIn = isset($_SESSION['user_id']);
require_once 'config/db.php';

$sql = "SELECT player_id, player_name, role, real_team, kda, points, image_url 
        FROM players 
        WHERE year_season = 2025 
        ORDER BY real_team, role";
$stmt = $pdo->query($sql);
$players = $stmt->fetchAll(PDO::FETCH_ASSOC);
// ——— Aquí randomizamos KDA y puntos ——–
foreach ($players as &$p) {
    // Kill/Death/Assist aleatorios
    $kills   = rand(0, 15);
    $deaths  = rand(0, 10);
    $assists = rand(0, 20);
    $p['kda']    = "{$kills}/{$deaths}/{$assists}";
    // Puntos aleatorios
    $p['points'] = rand(0, 50);
}
unset($p); // romper referencia

?>
<!DOCTYPE html>
<html lang="es">
<head>
<!-- favicon -->
<link rel="icon" href="/lol.ico" type="image/x-icon">
<link rel="shortcut icon" href="/lol.ico" type="image/x-icon">

  <meta charset="UTF-8">
  <title data-es="Jugadores - Rifty Fantasy" data-en="Players - Rifty Fantasy">Jugadores - Rifty Fantasy</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    html, body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f4f4f4;
      color: #333;
      transition: background-color 0.3s, color 0.3s;
    }
    body.dark-mode {
      background-color: #121212;
      color: #f5f5f5;
    }
    body.dark-mode nav {
      background-color: #1e1e1e;
    }
    body.dark-mode .player-card {
      background-color: #1f1f1f;
      border-color: #333;
    }
    body.dark-mode .card-header .team {
      color: #f06292;
    }
    body.dark-mode .card-header .role {
      color: #81c784;
    }
    body.dark-mode .player-name {
      color: #64b5f6;
    }
    body.dark-mode .stats-btn {
      background: #e57373;
    }
    body.dark-mode .stats-btn:hover {
      background: #ef5350;
    }
    body.dark-mode .extra-info {
      color: #ffb74d;
    }
    body.dark-mode footer {
      background-color: #1c1c1c;
      color: #aaa;
    }

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
    }
    .container {
      width: 90%;
      max-width: 1200px;
      margin: 20px auto;
      padding-bottom: 40px;
    }
    h1 {
      text-align: center;
      margin-bottom: 15px;
      color: #2c3e50;
    }
    p.lead {
      text-align: center;
      margin-bottom: 25px;
      font-size: 1.1rem;
    }
    .filters {
      display: flex;
      flex-wrap: wrap;
      gap: 10px;
      margin-bottom: 20px;
      justify-content: center;
      align-items: center;
    }
    .filters label {
      font-weight: bold;
    }
    .filters input[type="search"] {
      padding: 5px 10px;
      font-size: 1rem;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    .cards {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 20px;
    }
    .player-card {
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 6px;
      padding: 10px;
      text-align: center;
      position: relative;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .player-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    }
    .card-header {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
      font-size: 0.9rem;
      font-weight: bold;
    }
    .card-header .team {
      color: #e74c3c;
    }
    .card-header .role {
      color: #2ecc71;
    }
    .player-img {
      width: 100%;
      height: 120px;
      overflow: hidden;
      margin-bottom: 10px;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .player-img img {
      max-width: 100%;
      max-height: 100%;
      object-fit: cover;
      border-radius: 4px;
    }
    .player-name {
      font-size: 1.1rem;
      margin-bottom: 5px;
      color: #2980b9;
    }
    .stats {
      margin-bottom: 10px;
    }
    .stats p {
      font-size: 0.9rem;
      margin: 2px 0;
    }
    .stats-btn {
      background: #e74c3c;
      color: #fff;
      border: none;
      padding: 6px 10px;
      border-radius: 4px;
      cursor: pointer;
    }
    .stats-btn:hover {
      background: #c0392b;
    }
    .extra-info {
      margin-top: 5px;
      font-size: 0.95rem;
    }
    footer {
      text-align: center;
      padding: 15px;
      background-color: #222;
      color: #bbb;
      margin-top: 30px;
    }
  </style>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const modeToggle = document.getElementById('modeToggle');
      const langToggle = document.getElementById('langToggle');
      let currentLang = 'es';

      modeToggle.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
        modeToggle.textContent = document.body.classList.contains('dark-mode') ? "Modo Claro" : "Modo Oscuro";
      });
// —— FILTRADO POR ROL Y BÚSQUEDA —— 
const roleCheckboxes = document.querySelectorAll('input[name="roleFilter"]');
const searchInput    = document.getElementById('searchPlayer');
const cards          = document.querySelectorAll('.player-card');

function applyFilters() {
  const activeRoles = Array.from(roleCheckboxes)
                           .filter(ch => ch.checked)
                           .map(ch => ch.value.toLowerCase());
  const searchText = searchInput.value.trim().toLowerCase();

  cards.forEach(card => {
    const role = card.getAttribute('data-role').toLowerCase();
    const name = card.getAttribute('data-name').toLowerCase();

    const matchesRole   = activeRoles.length === 0 || activeRoles.includes(role);
    const matchesSearch = name.includes(searchText);

    // '' deja que recupere su estilo por defecto (grid-item)
    card.style.display = (matchesRole && matchesSearch) ? '' : 'none';
  });
}

// vinculamos los eventos
roleCheckboxes.forEach(ch => ch.addEventListener('change', applyFilters));
searchInput.addEventListener('input', applyFilters);

// (opcional) ejecutarlo al cargar para respetar un estado inicial
applyFilters();


      langToggle.addEventListener('click', () => {
        currentLang = currentLang === 'es' ? 'en' : 'es';
        document.querySelectorAll('[data-es],[data-en]').forEach(el => {
          el.textContent = el.getAttribute(`data-${currentLang}`) || el.textContent;
        });
      });
    });
  </script>
</head>
<body>
<nav>
  <ul>
    <li><a href="index.php" data-es="Inicio" data-en="Home">Inicio</a></li>
    <li><a href="jugadores.php" data-es="Jugadores" data-en="Players">Jugadores</a></li>
    <li><a href="clasi.php" data-es="Clasificación" data-en="Standings">Clasificación</a></li>
    <li><a href="reglas.php" data-es="Reglas" data-en="Rules">Reglas</a></li>
    <li class="navbar-right">
      <button id="modeToggle" class="mode-toggle" data-es="Modo Oscuro" data-en="Dark Mode">Modo Oscuro</button>
      <button id="langToggle" class="lang-toggle">EN/ES</button>
    </li>

    <?php if ($loggedIn): ?>
      <li style="display: flex; align-items: center; gap: 8px; color: #fff;">
        <span style="font-weight: bold;">👤 <?php echo htmlspecialchars($_SESSION['username']); ?></span>
        <a href="logout.php" data-es="Salir" data-en="Logout" style="color: #f39c12;">Logout</a>
      </li>
    <?php else: ?>
      <li><a href="login.php" data-es="Login" data-en="Login">Login</a></li>
      <li><a href="register.php" data-es="Register" data-en="Register">Register</a></li>
    <?php endif; ?>
  </ul>
</nav>

  <div class="container">
    <h1 data-es="Rifty - Fantasy LEC 2025" data-en="Rifty - Fantasy LEC 2025">Rifty - Fantasy LEC 2025</h1>
    <p class="lead" data-es="Filtra por rol o busca un jugador." data-en="Filter by role or search a player.">Filtra por rol o busca un jugador.</p>

    <div class="filters">
      <label data-es="Filtrar por Rol:" data-en="Filter by Role:">Filtrar por Rol:</label>
      <label><input type="checkbox" name="roleFilter" value="Top" data-es="Top" data-en="Top"> Top</label>
      <label><input type="checkbox" name="roleFilter" value="Jungle" data-es="Jungle" data-en="Jungle"> Jungle</label>
      <label><input type="checkbox" name="roleFilter" value="Mid" data-es="Mid" data-en="Mid"> Mid</label>
      <label><input type="checkbox" name="roleFilter" value="ADC" data-es="ADC" data-en="ADC"> ADC</label>
      <label><input type="checkbox" name="roleFilter" value="Support" data-es="Support" data-en="Support"> Support</label>
      <label style="margin-left:20px;" data-es="Buscar Jugador:" data-en="Search Player:">Buscar Jugador:</label>
      <input type="search" id="searchPlayer" placeholder="Nombre..." />
    </div>

    <div class="cards">
      <?php foreach ($players as $p): 
        $safeName = htmlspecialchars($p['player_name']);
        $safeRole = htmlspecialchars($p['role']);
        $safeTeam = htmlspecialchars($p['real_team']);
        $safeKDA  = htmlspecialchars($p['kda'] ?? '0/0/0');
        $safePts  = htmlspecialchars($p['points'] ?? '0');
        $safeImg  = htmlspecialchars($p['image_url'] ?? 'images/default.webp');
      ?>
      <div class="player-card" data-role="<?php echo $safeRole; ?>" data-name="<?php echo $safeName; ?>">
        <div class="card-header">
          <span class="team"><?php echo $safeTeam; ?></span>
          <span class="role"><?php echo $safeRole; ?></span>
        </div>
        <div class="player-img">
          <img src="<?php echo $safeImg; ?>" alt="<?php echo $safeName; ?>">
        </div>
        <h3 class="player-name"><?php echo $safeName; ?></h3>
        <div class="stats">
          <p class="kda">KDA: <?php echo $safeKDA; ?></p>
          <p class="points">Puntos: <?php echo $safePts; ?></p>
        </div>
<?php if (trim(strtolower($safeTeam)) === 'los ratones'): ?>
  <p class="extra-info"
     data-es="<?php echo (stripos($safeName, 'bau') !== false) ? 'Ganadores de la EMEA   Messi of League' : 'Ganadores de la EMEA'; ?>"
     data-en="<?php echo (stripos($safeName, 'bau') !== false) ? 'EMEA Masters Champions   Messi of League' : 'EMEA Champions'; ?>"
     style="font-weight: bold; color: #f39c12;">
    <?php echo (stripos($safeName, 'bau') !== false) ? 'Ganadores de la EMEA Messi of League' : 'Ganadores de la EMEA'; ?>
  </p>
<?php endif; ?>

          <button class="stats-btn" data-es="Ver Estadísticas" data-en="View Stats">Ver Estadísticas</button>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <footer>
    <p>&copy; 2025 RIFTY - LEC. Todos los derechos reservados.</p>
  </footer>
</body>
</html>
