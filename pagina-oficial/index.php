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
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title data-es="RIFTY FANTASYLOL" data-en="RIFTY FANTASYLOL">RIFTY FANTASYLOL</title>
  <style>
    /* RESET */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    html, body { height: 100%; font-family: 'Segoe UI', sans-serif; transition: background .3s, color .3s; }
    body { display: flex; flex-direction: column; min-height: 100vh; }

    /* TEMAS */
    body.light-mode { background: #f4f4f4; color: #333; }
    body.dark-mode  { background: #1f1f1f; color: #eee; }
    body.blue-mode  { background: #e0f7fa; color: #006064; }

    /* NAVBAR */
    nav {
      background: #222;
      padding: 15px;
      position: sticky;
      top: 0;
      z-index: 1000;
    }
    nav ul {
      list-style: none;
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: flex-start;   /* alinea todo a la izquierda */
      max-width: 1200px;
      margin: 0 auto;
    }
    nav li { margin: 0 10px; position: relative; }
    nav a {
      color: #fff;
      text-decoration: none;
      font-weight: bold;
      transition: color .3s;
    }
    nav a:hover { color: #f39c12; }

    /* User info a la izquierda */
    .user-info {
      color: #fff;
      font-weight: bold;
      margin-right: 20px;
    }

    /* Empuja todo lo de la derecha */
    .navbar-right { margin-left: auto; display: flex; gap: 10px; }

    .mode-toggle, .lang-toggle {
      background: #f39c12;
      color: #fff;
      border: none;
      padding: 8px 12px;
      border-radius: 4px;
      cursor: pointer;
      font-weight: bold;
      transition: background .3s;
    }
    .mode-toggle:hover, .lang-toggle:hover { background: #d98200; }

    /* Dropdowns */
    .form-dropdown {
      position: absolute;
      top: 60px; right: 20px;
      width: 260px;
      background: #fff;
      border: 1px solid #ccc;
      border-radius: 6px;
      padding: 15px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.2);
      display: none; z-index: 999;
      transition: background .3s, color .3s;
    }
    .form-dropdown h2 { margin-bottom:10px; font-size:1.1rem; text-align:center; color:#333; }
    .form-dropdown label { display:block; margin-top:10px; font-weight:bold; }
    .form-dropdown input {
      width:100%; padding:6px; margin:5px 0 10px;
      border:1px solid #ccc; border-radius:4px;
    }
    .form-dropdown button {
      width:100%; padding:8px; background:#2980b9; color:#fff;
      border:none; border-radius:4px; cursor:pointer;
      transition: background .3s;
    }
    .form-dropdown button:hover { background:#1f6690; }

    /* CONTENIDO */
    .container {
      flex:1; width:90%; max-width:1200px;
      margin:20px auto 40px;
    }
    .hero {
      display:flex; flex-wrap:wrap; gap:20px; align-items:center;
      background:#fff; border:1px solid #ddd; border-radius:6px;
      padding:20px; margin-bottom:30px;
      box-shadow:0 2px 5px rgba(0,0,0,0.1);
    }
    .hero-text { flex:1 1 400px; }
    .hero-text h1 {
      font-size:2rem; margin-bottom:10px;
      color:#e74c3c; text-transform:uppercase; letter-spacing:1px;
    }
    .hero-text p { margin-bottom:15px; line-height:1.4; }
    .hero-button {
      display:inline-block; background:#e74c3c; color:#fff;
      padding:12px 20px; border-radius:4px; text-decoration:none;
      font-weight:bold; transition:background .3s;
    }
    .hero-button:hover { background:#c0392b; }

    .info-section {
      display:flex; flex-wrap:wrap; gap:20px; margin-bottom:30px;
    }
    .info-box {
      flex:1 1 300px; background:#fff; border:1px solid #ddd;
      border-radius:6px; padding:20px;
      box-shadow:0 2px 5px rgba(0,0,0,0.1);
    }
    .info-box h2 {
      margin-bottom:10px; font-size:1.2rem; color:#2c3e50;
      border-bottom:2px solid #e74c3c; display:inline-block;
      padding-bottom:5px;
    }
    .info-box p { line-height:1.4; }

    .counters {
      display:flex; flex-wrap:wrap; gap:20px;
    }
    .counter-box {
      flex:1 1 200px; background:#fff; border:1px solid #ddd;
      border-radius:6px; text-align:center; padding:20px;
      box-shadow:0 2px 5px rgba(0,0,0,0.1);
    }
    .counter-box h3 {
      font-size:2rem; color:#e74c3c; margin-bottom:10px;
    }

    footer {
      text-align:center; padding:15px;
      background:#222; color:#bbb;
    }

    /* RESPONSIVE */
    @media (max-width:1024px) {
      .container { width:95%; max-width:100%; }
    }
    @media (max-width:768px) {
      nav ul { justify-content:flex-start; }
      .hero, .info-section, .counters { flex-direction:column; }
      .hero-button { width:100%; text-align:center; }
      .info-box, .counter-box { flex:1 1 100%; }
    }

    /* DARK MODE OVERRIDES */
    body.dark-mode .hero,
    body.dark-mode .info-box,
    body.dark-mode .counter-box,
    body.dark-mode .form-dropdown {
      background:#2f2f2f; border-color:#444; color:#eee;
    }
    body.dark-mode .hero-button { background:#c0392b; }
    body.dark-mode .hero-button:hover { background:#a83225; }
    body.dark-mode footer { background:#111; color:#ccc; }
  </style>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      // Modo oscuro
      const modeToggle = document.getElementById('modeToggle');
      modeToggle.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
        modeToggle.textContent = document.body.classList.contains('dark-mode')
          ? 'Modo Claro' : 'Modo Oscuro';
      });

      // Cambio de idioma
      const langToggle = document.getElementById('langToggle');
      let lang = 'es';
      langToggle.addEventListener('click', () => {
        lang = lang === 'es' ? 'en' : 'es';
        document.querySelectorAll('[data-es],[data-en]').forEach(el => {
          el.textContent = el.getAttribute(`data-${lang}`) || el.textContent;
        });
      });

      // Dropdowns
      const loginLink      = document.getElementById('loginLink'),
            registerLink   = document.getElementById('registerLink'),
            loginDD        = document.getElementById('loginDropdown'),
            registerDD     = document.getElementById('registerDropdown');

      if(loginLink) loginLink.addEventListener('click', e => {
        e.preventDefault();
        registerDD.style.display = 'none';
        loginDD.style.display = loginDD.style.display==='block'?'none':'block';
      });
      if(registerLink) registerLink.addEventListener('click', e => {
        e.preventDefault();
        loginDD.style.display = 'none';
        registerDD.style.display = registerDD.style.display==='block'?'none':'block';
      });
      document.addEventListener('click', e => {
        if(loginDD && !loginDD.contains(e.target) && e.target!==loginLink)
          loginDD.style.display='none';
        if(registerDD && !registerDD.contains(e.target) && e.target!==registerLink)
          registerDD.style.display='none';
      });
    });
  </script>
</head>
<body class="light-mode">
  <nav>
    <ul>

      <!-- Enlaces principales -->
      <li><a href="index.php" data-es="Inicio" data-en="Home">Inicio</a></li>
      <li><a href="jugadores.php" data-es="Jugadores" data-en="Players">Jugadores</a></li>
      <li><a href="clasi.php" data-es="Clasificación" data-en="Standings">Clasificación</a></li>
      <li><a href="reglas.php" data-es="Reglas" data-en="Rules">Reglas</a></li>

      <!-- Botones modo/idioma y login/register al final -->
      <li class="navbar-right">
        <button id="modeToggle" class="mode-toggle" data-es="Modo Oscuro" data-en="Dark Mode">Modo Oscuro</button>
        <button id="langToggle" class="lang-toggle" data-es="EN/ES" data-en="EN/ES">EN/ES</button>
      </li>
  <!-- Aquí va tu user-info -->
    <?php if($loggedIn): ?>
      <li class="user-info">👤 <?= htmlspecialchars($_SESSION['username']); ?></li>
    <?php endif; ?>
      <?php if($loggedIn): ?>
        <li><a href="logout.php" data-es="Logout" data-en="Logout">Logout</a></li>
      <?php else: ?>
        <li>
          <a href="#" id="loginLink" data-es="Login" data-en="Login">Login</a>
          <div id="loginDropdown" class="form-dropdown">
            <h2 data-es="Iniciar Sesión" data-en="Sign In">Iniciar Sesión</h2>
            <form action="login.php" method="POST">
              <label for="emailLogin" data-es="Email" data-en="Email">Email</label>
              <input type="email" name="email" id="emailLogin" required autocomplete="email">
              <label for="passLogin" data-es="Contraseña" data-en="Password">Contraseña</label>
              <input type="password" name="password" id="passLogin" required autocomplete="current-password">
              <button type="submit" data-es="Entrar" data-en="Sign In">Entrar</button>
            </form>
          </div>
        </li>
        <li>
          <a href="#" id="registerLink" data-es="Register" data-en="Register">Register</a>
          <div id="registerDropdown" class="form-dropdown">
            <h2 data-es="Crear Cuenta" data-en="Create Account">Crear Cuenta</h2>
            <form action="register.php" method="POST">
              <label for="usernameReg" data-es="Nombre de Usuario" data-en="Username">Nombre de Usuario</label>
              <input type="text" name="username" id="usernameReg" required autocomplete="username">
              <label for="emailReg" data-es="Email" data-en="Email">Email</label>
              <input type="email" name="email" id="emailReg" required autocomplete="email">
              <label for="passReg" data-es="Contraseña" data-en="Password">Contraseña</label>
              <input type="password" name="password" id="passReg" required autocomplete="new-password">
              <button type="submit" data-es="Registrarme" data-en="Register">Registrarme</button>
            </form>
          </div>
        </li>
      <?php endif; ?>
    </ul>
  </nav>

  <div class="container">
    <!-- HERO -->
    <div class="hero">
      <div class="hero-text">
        <h1 data-es="RIFTY FANTASYLOL" data-en="RIFTY FANTASYLOL">RIFTY FANTASYLOL</h1>
        <p data-es="Crea tu equipo y compite con los mejores jugadores profesionales en la liga europea..."
           data-en="Build your team and compete with top professional players in the European league...">
          Crea tu equipo y compite con los mejores jugadores profesionales en la liga europea...
        </p>
        <a href="jugadores.php" class="hero-button" data-es="CREA TU PROPIO EQUIPO" data-en="CREATE YOUR OWN TEAM">
          CREA TU PROPIO EQUIPO
        </a>
      </div>
    </div>

    <!-- INFO SECTIONS -->
    <div class="info-section">
      <div class="info-box">
        <h2 data-es="Cómo jugar" data-en="How to play">Cómo jugar</h2>
        <p data-es="Elige tus jugadores favoritos y crea una alineación ganadora."
           data-en="Choose your favorite players and build a winning lineup.">
          Elige tus jugadores favoritos y crea una alineación ganadora.
        </p>
      </div>
      <div class="info-box">
        <h2 data-es="Puntuación" data-en="Scoring">Puntuación</h2>
        <p data-es="Cada jugador suma puntos según su desempeño en la jornada."
           data-en="Each player earns points based on their performance in the matchday.">
          Cada jugador suma puntos según su desempeño en la jornada.
        </p>
      </div>
      <div class="info-box">
        <h2 data-es="Características" data-en="Features">Características</h2>
        <p data-es="Interfaz intuitiva, estadísticas en tiempo real y torneos semanales."
           data-en="Intuitive interface, real-time stats, and weekly tournaments.">
          Interfaz intuitiva, estadísticas en tiempo real y torneos semanales.
        </p>
      </div>
    </div>

    <!-- CONTADORES -->
    <div class="counters">
      <div class="counter-box">
        <h3 data-es="500+" data-en="500+">500+</h3>
        <p data-es="Jugadores disponibles" data-en="Players available">Jugadores disponibles</p>
      </div>
      <div class="counter-box">
        <h3 data-es="50+" data-en="50+">50+</h3>
        <p data-es="Equipos para elegir" data-en="Teams to choose">Equipos para elegir</p>
      </div>
      <div class="counter-box">
        <h3 data-es="24/7" data-en="24/7">24/7</h3>
        <p data-es="Soporte siempre disponible" data-en="Support always available">Soporte siempre disponible</p>
      </div>
    </div>
  </div>

  <footer>
    <p>&copy; 2025 RIFTY - LEC. Todos los derechos reservados.</p>
  </footer>
</body>
</html>
