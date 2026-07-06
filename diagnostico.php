<?php
include_once('security.php');
include('config.php');

// Restricción de seguridad perimetral basada estrictamente en el puesto del empleado
if(!isset($_SESSION['puesto']) || strtolower($_SESSION['puesto']) != 'soporte tecnico it'){
    die("<h2 style='color:#b91c1c; font-family:sans-serif; padding:30px;'>⛔ Acceso denegado: Este módulo requiere la asignación funcional de 'Soporte Tecnico IT'.</h2>");
}

include('sidebar.php');

$resultado = "";

if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['host']) && !isset($_POST['toggle_mode'])){
    $host = $_POST['host'];

    if ($DEFENSIVE_MODE) {
        // 🟢 BLUE TEAM: Validación rigurosa de IP y sanitización con escapeshellarg()
        if (filter_var($host, FILTER_VALIDATE_IP)) {
            $resultado = shell_exec("/usr/bin/ping -c 2 " . escapeshellarg($host));
        } else {
            $resultado = "❌ ERROR DE INFRAESTRUCTURA: Host inválido. En el modo hardening del TFG solo se admiten direcciones IP lógicas.";
        }
    } else {
        // 🔴 RED TEAM: Concatenación directa e insegura en el intérprete del sistema
        $resultado = shell_exec($host);
    }
}
?>

<?php mostrar_banner_seguridad($DEFENSIVE_MODE); ?>

<div style="padding: 30px; font-family: sans-serif;">
    <h1 style="color: #0f172a; margin-top: 0;">🖥️ Centro de Diagnóstico de Infraestructura</h1>
    <p style="color: #475569;">Herramienta operacional para verificar la conectividad de activos y servidores dentro del direccionamiento de GlobalTech.</p>

    <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 30px 0;">

    <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); max-width: 700px;">
        <h3 style="color: #1e3a8a; margin-top: 0; margin-bottom: 20px;">🔍 Verificar Conectividad (ICMP Ping)</h3>
        
        <form method="POST" action="">
            <label style="display: block; margin-bottom: 8px; font-size: 14px; font-weight: bold; color: #334155;">Dirección IP o Nombre de Host del Equipo:</label>
            <div style="display: flex; gap: 10px; margin-bottom: 20px;">
                <input type="text" name="host" placeholder="Ej: 10.0.20.10" style="flex: 1; padding: 10px; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 14px;" required>
                <button type="submit" style="background: #1e293b; color: white; padding: 10px 20px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">Ejecutar Test</button>
            </div>
        </form>

        <?php if($resultado !== ""): ?>
            <h4 style="color: #334155; margin-bottom: 10px;">📊 Respuesta de la Consola del Sistema:</h4>
            <pre style="background: #0f172a; color: #38bdf8; padding: 20px; border-radius: 6px; font-family: monospace; font-size: 13px; margin: 0; overflow-x: auto; white-space: pre-wrap;"><?php echo htmlspecialchars($resultado); ?></pre>
        <?php endif; ?>
    </div>
</div>

</div> </body> </html>
