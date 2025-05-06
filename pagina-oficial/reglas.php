<?php
session_start();
$loggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<!-- favicon -->
<link rel="icon" href="/lol.ico" type="image/x-icon">
<link rel="shortcut icon" href="/lol.ico" type="image/x-icon">

  <meta charset="UTF-8">
  <title data-es="Reglas Rifty" data-en="Rifty Rules">Reglas Rifty</title>
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
      line-height: 1.4;
      transition: background-color 0.3s, color 0.3s;
    }
    body.dark-mode {
      background-color: #1f1f1f;
      color: #eee;
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
      justify-content: center;
      align-items: center;
      gap: 20px;
      max-width: 1200px;
      margin: 0 auto;
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
      margin-left: auto;
      display: flex;
      gap: 10px;
    }

    /* BOTONES DE MODO OSCURO Y TRADUCCIÓN */
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
      font-size: 1.8rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      transition: color 0.3s;
    }
    /* CAJAS DE REGLAS */
    .rule-box {
      background: #fff;
      border: 1px solid #ddd;
      border-radius: 8px;
      padding: 20px 25px;
      margin-bottom: 20px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.07);
      transition: background-color 0.3s, color 0.3s, border-color 0.3s;
    }
    .rule-box h2 {
      margin-bottom: 15px;
      font-size: 1.3rem;
      color: #d35400;
      text-transform: uppercase;
      border-bottom: 2px solid #d35400;
      display: inline-block;
      padding-bottom: 5px;
      letter-spacing: 0.5px;
      transition: color 0.3s, border-color 0.3s;
    }
    .rule-box p {
      margin-bottom: 10px;
      font-size: 0.95rem;
      transition: color 0.3s;
    }
    .rule-box ul {
      margin-left: 20px;
      margin-bottom: 10px;
      list-style: disc;
      transition: color 0.3s;
    }
    .rule-box ul li {
      margin-bottom: 5px;
    }

    /* BOTONES */
    .btn {
      display: inline-block;
      padding: 10px 15px;
      border-radius: 4px;
      text-decoration: none;
      font-weight: bold;
      transition: background 0.3s;
      margin-top: 10px;
    }
    .btn-primary {
      background: #e74c3c;
      color: #fff;
    }
    .btn-primary:hover {
      background: #c0392b;
    }
    .btn-secondary {
      background: #3498db;
      color: #fff;
    }
    .btn-secondary:hover {
      background: #2980b9;
    }

    .text-center {
      text-align: center;
    }
    .mt-20 {
      margin-top: 20px;
    }

    /* FOOTER */
    footer {
      text-align: center;
      padding: 15px;
      background-color: #222;
      color: #bbb;
      margin-top: 30px;
      transition: background-color 0.3s, color 0.3s;
    }

    /* MODO OSCURO PARA LAS CAJAS */
    body.dark-mode .rule-box {
      background-color: #2f2f2f;
      border-color: #444;
      color: #eee;
    }
    body.dark-mode .rule-box h2 {
      color: #ff9f4a; /* Un naranja más claro */
      border-color: #ff9f4a;
    }
    body.dark-mode .rule-box p,
    body.dark-mode .rule-box ul,
    body.dark-mode .rule-box ul li {
      color: #ddd;
    }
    /* Ajustar color de h1 en modo oscuro */
    body.dark-mode h1 {
      color: #ff9f4a;
    }
    /* Ajustar botones en modo oscuro */
    body.dark-mode .btn-primary {
      background: #c0392b;
    }
    body.dark-mode .btn-primary:hover {
      background: #a93226;
    }
    body.dark-mode .btn-secondary {
      background: #2980b9;
    }
    body.dark-mode .btn-secondary:hover {
      background: #1f6690;
    }
  </style>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // MODO OSCURO y TRADUCCIÓN
      const body = document.body;
      const modeToggle = document.getElementById('modeToggle');
      const langToggle = document.getElementById('langToggle');

      modeToggle.addEventListener('click', () => {
        // Alternar la clase dark-mode
        if (body.classList.contains('dark-mode')) {
          body.classList.remove('dark-mode');
          modeToggle.textContent = "Modo Oscuro";
        } else {
          body.classList.add('dark-mode');
          modeToggle.textContent = "Modo Claro";
        }
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
        <li style="position: relative;">
          <a href="login.php" data-es="Login" data-en="Login">Login</a>
        </li>
        <li style="position: relative;">
          <a href="register.php" data-es="Register" data-en="Register">Register</a>
        </li>
      <?php endif; ?>
    </ul>
  </nav>

  <!-- CONTENIDO -->
  <div class="container">
    <h1 data-es="Reglas Rifty" data-en="Rifty Rules">Reglas Rifty</h1>

    <!-- CAJAS DE REGLAS -->
    <div class="rule-box">
      <h2 data-es="Ligas" data-en="Leagues">Ligas</h2>
      <p data-es="Puedes unirte a una liga existente o crear una nueva." data-en="You can join an existing league or create a new one.">Puedes unirte a una liga existente o crear una nueva.</p>
      <p data-es="Cada liga puede tener varios miembros o participantes." data-en="Each league can have several members or participants.">Cada liga puede tener varios miembros o participantes.</p>
      <p data-es="Las ligas pueden ser públicas o privadas, restringiendo la entrada con invitación." data-en="Leagues can be public or private, restricting entry by invitation.">Las ligas pueden ser públicas o privadas, restringiendo la entrada con invitación.</p>
      <p data-es="El usuario que crea la liga es el administrador de la misma." data-en="The user who creates the league is its administrator.">El usuario que crea la liga es el administrador de la misma.</p>
    </div>

    <div class="rule-box">
      <h2 data-es="Equipo" data-en="Team">Equipo</h2>
      <p data-es="Tendrás total libertad para gestionar tu equipo." data-en="You will have full freedom to manage your team.">Tendrás total libertad para gestionar tu equipo.</p>
      <p data-es="Cada equipo puede alinear a varios jugadores en distintas posiciones, según las normas de la liga." data-en="Each team can field several players in different positions, according to the league rules.">Cada equipo puede alinear a varios jugadores en distintas posiciones, según las normas de la liga.</p>
      <p data-es="Podrás tener tantos jugadores en plantilla como quieras, dentro de un límite presupuestario." data-en="You can have as many players on your roster as you want, within a budget limit.">Podrás tener tantos jugadores en plantilla como quieras, dentro de un límite presupuestario.</p>
      <p data-es="Deberás estar presente al inicio de la jornada para definir tu alineación." data-en="You must be present at the beginning of the matchday to set your lineup.">Deberás estar presente al inicio de la jornada para definir tu alineación.</p>
    </div>

    <div class="rule-box">
      <h2 data-es="Cálculo de puntos" data-en="Scoring">Cálculo de puntos</h2>
      <p data-es="Los puntos se calculan en función del rendimiento real de los jugadores en la LEC." data-en="Points are calculated based on the players' real performance in the LEC.">Los puntos se calculan en función del rendimiento real de los jugadores en la LEC.</p>
      <p data-es="La actualización se hace cada jornada, normalmente a las 00:00." data-en="Updates occur after each matchday, typically at midnight.">La actualización se hace cada jornada, normalmente a las 00:00.</p>
      <p data-es="Recibirás 15-30 puntos base por cada victoria y 5-15 puntos adicionales por su KDA." data-en="You receive a base of 15-30 points per win plus an additional 5-15 points for their KDA.">Recibirás 15-30 puntos base por cada victoria y 5-15 puntos adicionales por su KDA.</p>
      <p data-es="Cada día de partida cuenta como una mini-jornada para sumar puntos en el ranking." data-en="Each matchday counts as a mini-matchday to accumulate ranking points.">Cada día de partida cuenta como una mini-jornada para sumar puntos en el ranking.</p>
    </div>

    <div class="rule-box">
      <h2 data-es="Sistema de Puntuación" data-en="Scoring System">Sistema de Puntuación</h2>
      <p data-es="Las puntuaciones se calculan en función del rendimiento real de los jugadores." data-en="Scores are calculated based on the players' real performance.">Las puntuaciones se calculan en función del rendimiento real de los jugadores.</p>
      <p data-es="Métricas: Kills, Assists y Deaths." data-en="Metrics: Kills, Assists, and Deaths.">Métricas: Kills, Assists y Deaths.</p>
      <ul>
        <li data-es="+2 puntos por cada kill" data-en="+2 points per kill">+2 puntos por cada kill</li>
        <li data-es="+1 punto por cada assist" data-en="+1 point per assist">+1 punto por cada assist</li>
        <li data-es="-2 puntos por cada muerte" data-en="-2 points per death">-2 puntos por cada muerte</li>
      </ul>
    </div>

    <div class="rule-box">
      <h2 data-es="Objetivos neutrales" data-en="Neutral Objectives">Objetivos neutrales</h2>
      <p data-es="Los jugadores también reciben puntos por objetivos neutrales." data-en="Players also earn points for neutral objectives.">Los jugadores también reciben puntos por objetivos neutrales.</p>
      <ul>
        <li data-es="+1 punto extra por cada dragón" data-en="+1 extra point per dragon">+1 punto extra por cada dragón</li>
        <li data-es="+2 puntos extra por cada Barón Nashor conseguido" data-en="+2 extra points per Barón Nashor">+2 puntos extra por cada Barón Nashor conseguido</li>
        <li data-es="+2 puntos extra por Atakhan " data-en="+2 extra points for Atakhan ">+2 puntos extra por Atakhan</li>
      </ul>
    </div>

    <div class="rule-box">
      <h2 data-es="Mercado de Jugadores" data-en="Player Market">Mercado de Jugadores</h2>
      <p data-es="Cada día, 5 nuevos jugadores se ponen a la venta en el mercado." data-en="Each day, 5 new players are put up for sale in the market.">Cada día, 5 nuevos jugadores se ponen a la venta en el mercado.</p>
      <p data-es="Las pujas son anónimas y cada usuario lanza una oferta en secreto." data-en="Bids are anonymous and each user makes a secret offer.">Las pujas son anónimas y cada usuario lanza una oferta en secreto.</p>
      <p data-es="El mercado se actualiza diariamente a las 00:00 CET." data-en="The market updates daily at 00:00 CET.">El mercado se actualiza diariamente a las 00:00 CET.</p>
      <p data-es="Los jugadores permanecen en el mercado hasta que el usuario decida retirarlos." data-en="Players remain on the market until the user decides to withdraw them.">Los jugadores permanecen en el mercado hasta que el usuario decida retirarlos.</p>
    </div>

    <div class="rule-box">
      <h2 data-es="Cláusulas" data-en="Buyout Clauses">Cláusulas</h2>
      <p data-es="Pueden fichar jugadores pagando su cláusula." data-en="Players can be signed by paying their buyout clause.">Pueden fichar jugadores pagando su cláusula.</p>
      <p data-es="El precio se calcula en base a la media de sus últimas 10 partidas y su rol." data-en="The price is calculated based on the average of their last 10 games and their role.">El precio se calcula en base a la media de sus últimas 10 partidas y su rol.</p>
      <p data-es="Un jugador no puede recibir más de un fichaje por cláusula en la misma jornada." data-en="A player cannot be signed by clause more than once in the same matchday.">Un jugador no puede recibir más de un fichaje por cláusula en la misma jornada.</p>
    </div>

    <div class="text-center mt-20">
    </div>
  </div>

  <footer>
    <p>&copy; 2025 RIFTY - LEC. Todos los derechos reservados.</p>
  </footer>
</body>
</html>
