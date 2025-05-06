<?php
session_start();
require_once 'config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($email) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
	    $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Email o contraseña incorrectos.";
        }
    } else {
        $error = "Por favor, completa todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<!-- favicon -->
<link rel="icon" href="/lol.ico" type="image/x-icon">
<link rel="shortcut icon" href="/lol.ico" type="image/x-icon">

  <meta charset="UTF-8">
  <title>Iniciar sesión - Rifty Fantasy</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f2f2f2;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .login-container {
      background: #fff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
    }
    h2 {
      text-align: center;
      color: #2c3e50;
      margin-bottom: 20px;
    }
    .form-group {
      margin-bottom: 15px;
    }
    label {
      font-weight: bold;
      display: block;
      margin-bottom: 6px;
    }
    input {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 1rem;
    }
    button {
      width: 100%;
      padding: 12px;
      background-color: #e74c3c;
      color: #fff;
      font-weight: bold;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s;
    }
    button:hover {
      background-color: #c0392b;
    }
    .error {
      color: red;
      text-align: center;
      margin-bottom: 10px;
    }
    .register-link {
      text-align: center;
      margin-top: 15px;
      font-size: 0.9rem;
    }
    .register-link a {
      color: #3498db;
      text-decoration: none;
    }
    .register-link a:hover {
      text-decoration: underline;
    }
.show-pass {
  margin-top: 5px;
  font-size: 0.85rem;
  cursor: pointer;
  color: #555;
  user-select: none;
}

  </style>
</head>
<body>
  <div class="login-container">
    <h2>Iniciar sesión</h2>
    <?php if ($error): ?>
      <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="POST">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required autocomplete="email">
      </div>
<div class="form-group">
  <label for="password">Contraseña:</label>
  <input type="password" name="password" id="password" required autocomplete="current-password">
  <div class="show-pass" onclick="togglePassword()">👁 Mostrar contraseña</div>
</div>

      <button type="submit">Entrar</button>
    </form>
    <div class="register-link">
      ¿No tienes cuenta? <a href="register.php">Regístrate aquí</a>
    </div>
  </div>
<script>
  function togglePassword() {
    const input = document.getElementById("password");
    const toggle = document.querySelector(".show-pass");

    if (input.type === "password") {
      input.type = "text";
      toggle.textContent = "🙈 Ocultar contraseña";
    } else {
      input.type = "password";
      toggle.textContent = "👁 Mostrar contraseña";
    }
  }
</script>
</body>
</html>
