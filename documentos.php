<?php
include_once('security.php');
include('config.php');
include('sidebar.php');
?>

<?php mostrar_banner_seguridad($DEFENSIVE_MODE); ?>

<div style="padding: 30px; font-family: sans-serif;">
    <h1 style="color: #0f172a; margin-top: 0;">📂 Repositorio Documental Corporativo</h1>
    <p style="color: #475569;">Lector centralizado de manuales internos, normativas y procedimientos operativos.</p>

    <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 30px 0;">

    <div style="display: flex; gap: 30px;">
        <!-- Índice de Archivos -->
        <div style="width: 280px; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); height: fit-content;">
            <h4 style="margin-top: 0; color: #1e3a8a; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px;">📄 Índice de Manuales</h4>
            <ul style="list-style: none; padding: 0; margin: 0; font-size: 14px;">
                <li style="margin-bottom: 10px;"><a href="documentos.php?file=bienvenida.txt" style="color: #334155; text-decoration: none; display: block; padding: 8px; border-radius: 4px; background: #f8fafc; font-weight: bold;">👋 1. Manual de Bienvenida</a></li>
                <li style="margin-bottom: 10px;"><a href="documentos.php?file=seguridad.txt" style="color: #334155; text-decoration: none; display: block; padding: 8px; border-radius: 4px; background: #f8fafc; font-weight: bold;">🔒 2. Política de Seguridad</a></li>
            </ul>
        </div>

        <!-- Lector Dinámico -->
        <div style="flex: 1; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); min-height: 300px;">
            <h4 style="margin-top: 0; color: #0f172a; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px;">🖥️ Visor de Recursos del Servidor</h4>
            
            <?php
            if (isset($_GET['file'])) {
                $file = $_GET['file'];
                echo "<p style='font-size: 12px; color: #64748b; margin-bottom: 15px;'>Cargando recurso: <code>" . htmlspecialchars($file) . "</code></p>";
                echo "<div style='background: #0f172a; color: #38bdf8; padding: 20px; border-radius: 6px; font-family: monospace; white-space: pre-wrap;'>";
                
                if ($DEFENSIVE_MODE) {
                    // 🟢 BLUE TEAM: Mitigación LFI usando Lista Blanca estricta
                    $permitidos = ["bienvenida.txt", "seguridad.txt"];
                    if (in_array($file, $permitidos)) {
                        include($file);
                    } else {
                        echo "❌ ERROR DEFENSIVO: Archivo no permitido por la política perimetral.";
                    }
                } else {
                    // 🔴 RED TEAM: Inclusión directa vulnerable a Path Traversal y Wrappers
                    include($file);
                }
                
                echo "</div>";
            } else {
                echo "<p style='color: #64748b; font-size: 14px; text-align: center; margin-top: 80px;'>Selecciona un manual corporativo en la barra izquierda para cargarlo en el visor.</p>";
            }
            ?>
        </div>
    </div>
</div>

</div> </body> </html>
