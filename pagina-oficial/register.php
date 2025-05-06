<?php
session_start();
require_once 'config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (!empty($username) && !empty($email) && !empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        try {
            $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$username, $email, $hashedPassword]);
            header("Location: login.php");
            exit;
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    } else {
        $error = "Todos los campos son obligatorios.";
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
  <title>Registro - Rifty Fantasy</title>
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
    .register-container {
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
      background-color: #3498db;
      color: #fff;
      font-weight: bold;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background 0.3s;
    }
    button:hover {
      background-color: #2980b9;
    }
    .error {
      color: red;
      text-align: center;
      margin-bottom: 10px;
    }
    .login-link {
      text-align: center;
      margin-top: 15px;
      font-size: 0.9rem;
    }
    .login-link a {
      color: #e74c3c;
      text-decoration: none;
    }
    .login-link a:hover {
      text-decoration: underline;
    }
    .show-pass {
      margin-top: 5px;
      font-size: 0.85rem;
      cursor: pointer;
      color: #555;
    }
  </style>
</head>
<body>
  <div class="register-container">
    <h2>Crear cuenta</h2>
    <?php if ($error): ?>
      <p class="error"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="POST">
      <div class="form-group">
        <label for="username">Nombre de Usuario:</label>
        <input type="text" name="username" id="username" required autocomplete="username">
      </div>
      <div class="form-group">
        <label for="email">Correo Electrónico:</label>
        <input type="email" name="email" id="email" required autocomplete="email">
      </div>
      <div class="form-group">
        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required autocomplete="new-password">
        <div class="show-pass" onclick="togglePassword()">👁 Mostrar contraseña</div>
      </div>
      <button type="submit">Registrarse</button>
    </form>
    <div class="login-link">
      ¿Ya tienes cuenta? <a href="login.php">Inicia sesión</a>
    </div>
  </div>

  <script>
    function togglePassword() {
      const passField = document.getElementById('password');
      passField.type = passField.type === 'password' ? 'text' : 'password';
    }
  </script>
</body>
</html>
