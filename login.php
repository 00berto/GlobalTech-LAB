<?php
include_once('security.php');
include('config.php');

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['toggle_mode'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    if ($DEFENSIVE_MODE) {
        // 🟢 BLUE TEAM: Consultas preparadas parametrizadas que mitigan SQLi
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = ? AND password = ?");
        $stmt->bind_param("ss", $user, $pass);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        // 🔴 RED TEAM: Consulta concatenada ideal para Blind SQLi
        $query = "SELECT * FROM usuarios WHERE username = '$user' AND password = '$pass'";
        $result = $conn->query($query);
    }

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['usuario'] = $row['username'];
        $_SESSION['nombre'] = $row['nombre'];
        $_SESSION['rol'] = $row['rol'];
        $_SESSION['puesto'] = $row['puesto'];
        $_SESSION['id'] = $row['id']; // Esencial para el control de IDOR posterior
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Credenciales corporativas incorrectas.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>GlobalTech Solutions - Intranet Login</title>
</head>
<body style="font-family: sans-serif; background: #0f172a; margin: 0; padding: 0;">

    <?php mostrar_banner_seguridad($DEFENSIVE_MODE); ?>

    <div style="display: flex; justify-content: center; align-items: center; height: calc(100vh - 44px); margin: 0;">
        <div style="background: #1e293b; padding: 40px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.3); text-align: center; width: 350px; color: white;">
            <h2 style="margin-bottom: 5px; color: #38bdf8;">🌐 GlobalTech</h2>
            <p style="font-size: 13px; color: #94a3b8; margin-top: 0; margin-bottom: 30px;">Acceso restringido a personal autorizado</p>
            
            <form method="POST" action="">
                <input type="text" name="username" placeholder="Usuario corporativo" style="width: 100%; padding: 12px; margin-bottom: 15px; border-radius: 6px; border: 1px solid #334155; background: #0f172a; color: white; box-sizing: border-box;" required><br>
                <input type="password" name="password" placeholder="Contraseña" style="width: 100%; padding: 12px; margin-bottom: 25px; border-radius: 6px; border: 1px solid #334155; background: #0f172a; color: white; box-sizing: border-box;" required><br>
                <button type="submit" style="width: 100%; padding: 12px; background: #38bdf8; border: none; color: #0f172a; font-weight: bold; border-radius: 6px; cursor: pointer;">Iniciar Sesión</button>
            </form>

            <?php if($error): ?>
                <p style="color: #f87171; font-size: 14px; margin-top: 20px;"><?php echo $error; ?></p>
            <?php endif; ?>

            <?php mostrar_interruptor_seguridad($DEFENSIVE_MODE); ?>
        </div>
    </div>

</body>
</html>
