<?php
include_once('security.php');
include('config.php');

// Endpoint de API moderna: rrhh.php?id=3
if (isset($_GET['id'])) {
    header('Content-Type: application/json');
    $my_id = $_GET['id']; 

    if ($DEFENSIVE_MODE) {
        // 🟢 BLUE TEAM: Conversión de tipos y validación de propiedad de recursos (Mitigación IDOR/BOLA)
        $id_limpio = (int)$my_id;
        
        // El empleado solo puede ver sus registros, a menos que su rol corporativo sea 'RRHH'
        $usuario_sesion = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : '';
        $rol_sesion = isset($_SESSION['rol']) ? strtolower($_SESSION['rol']) : '';

        if ($rol_sesion === 'rrhh') {
            $stmt = $conn->prepare("SELECT n.*, u.nombre, u.puesto FROM nominas n JOIN usuarios u ON n.usuario_id = u.id WHERE n.id = ?");
            $stmt->bind_param("i", $id_limpio);
        } else {
            $stmt = $conn->prepare("SELECT n.*, u.nombre, u.puesto FROM nominas n JOIN usuarios u ON n.usuario_id = u.id WHERE n.id = ? AND u.username = ?");
            $stmt->bind_param("is", $id_limpio, $usuario_sesion);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        // 🔴 RED TEAM: Consulta SQL concatenada sin validación de privilegios de acceso
        $query = "SELECT n.*, u.nombre, u.puesto FROM nominas n JOIN usuarios u ON n.usuario_id = u.id WHERE n.id = $my_id";
        $result = $conn->query($query);
    }

    if ($result && $result->num_rows > 0) {
        echo json_encode($result->fetch_assoc(), JSON_PRETTY_PRINT);
    } else {
        http_response_code(403);
        echo json_encode(["error" => "Acceso denegado: Registro no autorizado para este perfil funcional."], JSON_PRETTY_PRINT);
    }
    exit; 
}

include('sidebar.php');
?>

<?php mostrar_banner_seguridad($DEFENSIVE_MODE); ?>

<div style="padding: 30px; font-family: sans-serif;">
    <h1 style="color: #0f172a; margin-top: 0;">Portal de Recursos Humanos</h1>
    <p style="color: #475569;">Gestión interna de expedientes laborales y retribuciones.</p>

    <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 30px 0;">

    <div style="background: white; padding: 25px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <h3 style="color: #1e3a8a; margin-top: 0;">Mis Nóminas Disponibles</h3>
        <table style="width: 100%; border-collapse: collapse; margin-top: 15px; font-size: 14px;">
            <thead>
                <tr style="background: #f1f5f9; text-align: left;">
                    <th style="padding: 12px; border-bottom: 2px solid #cbd5e1;">Periodo</th>
                    <th style="padding: 12px; border-bottom: 2px solid #cbd5e1;">Concepto</th>
                    <th style="padding: 12px; border-bottom: 2px solid #cbd5e1;">Acción</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 12px; border-bottom: 1px solid #e2e8f0; font-weight: bold;">Junio 2026</td>
                    <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;">Nómina Mensual Ordinaria</td>
                    <td style="padding: 12px; border-bottom: 1px solid #e2e8f0;">
                        <a href="rrhh.php?id=3" style="background: #38bdf8; color: #0f172a; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-weight: bold; font-size: 12px;">Visualizar Recibo (API)</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

</div> </body> </html>
