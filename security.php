<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Procesar el cambio de modo si se envía el formulario del interruptor
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle_mode'])) {
    $isSecure = ($_POST['toggle_mode'] === 'secure');
    $_SESSION['DEFENSIVE_MODE'] = $isSecure;
    
    // RUTA DEL .HTACCESS DE HARDENING
    $dir_uploads = __DIR__ . "/uploads/";
    $htaccess_file = $dir_uploads . ".htaccess";

    if ($isSecure) {
        // 🟢 BLUE TEAM: Crear dinámicamente el bloqueo en Apache
        $content = "<FilesMatch \"\.(php|php5|phtml|php7|phps)$\">\n";
        $content .= "    Order Deny,Allow\n";
        $content .= "    Deny from all\n";
        $content .= "</FilesMatch>\n";
        $content .= "php_admin_flag engine off\n";
        $content .= "RemoveHandler .php\n";
        $content .= "Options -ExecCGI\n";

        if (!file_exists($dir_uploads)) {
            mkdir($dir_uploads, 0755, true);
        }
        file_put_contents($htaccess_file, $content);
    } else {
        // 🔴 RED TEAM: Eliminar el .htaccess para permitir la ejecución de exploits
        if (file_exists($htaccess_file)) {
            unlink($htaccess_file);
        }
    }

    // Redirigir a la misma página para evitar reenvío de formulario al recargar
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}

// Por defecto, inicializar en modo ofensivo (RED TEAM = false)
if (!isset($_SESSION['DEFENSIVE_MODE'])) {
    $_SESSION['DEFENSIVE_MODE'] = false;
}

$DEFENSIVE_MODE = $_SESSION['DEFENSIVE_MODE'];

/**
 * Muestra el banner informativo en la parte superior de cada página
 */
function mostrar_banner_seguridad($mode) {
    if ($mode) {
        echo '
        <div style="background: #16a34a; color: white; padding: 12px 20px; text-align: center; font-family: sans-serif; font-size: 14px; font-weight: bold; box-shadow: 0 2px 4px rgba(0,0,0,0.2); z-index: 9999; position: relative;">
            🟢 Defensive Mode — Las recomendaciones de seguridad del TFG se encuentran aplicadas en este entorno (Código + Hardening de Servidor).
        </div>';
    } else {
        echo '
        <div style="background: #dc2626; color: white; padding: 12px 20px; text-align: center; font-family: sans-serif; font-size: 14px; font-weight: bold; box-shadow: 0 2px 4px rgba(0,0,0,0.2); z-index: 9999; position: relative;">
            🔴 Offensive Mode — Este laboratorio reproduce vulnerabilidades con fines exclusivamente educativos.
        </div>';
    }
}

/**
 * Muestra el botón de alternancia interactivo
 */
function mostrar_interruptor_seguridad($mode) {
    $texto_boton = $mode ? "Cambiar a Offensive Mode" : "Cambiar a Defensive Mode";
    $valor_accion = $mode ? "vulnerable" : "secure";
    $color_boton = $mode ? "#dc2626" : "#16a34a";
    
    echo '
    <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid #334155; font-family: sans-serif;">
        <p style="font-size: 12px; color: #94a3b8; margin-bottom: 12px;">Control del Laboratorio de Ciberseguridad</p>
        <form method="POST" action="">
            <input type="hidden" name="toggle_mode" value="' . $valor_accion . '">
            <button type="submit" style="width: 100%; padding: 10px; background: ' . $color_boton . '; border: none; color: white; font-weight: bold; border-radius: 6px; cursor: pointer; transition: background 0.2s;">
                🔄 ' . $texto_boton . '
            </button>
        </form>
    </div>';
}
?>
