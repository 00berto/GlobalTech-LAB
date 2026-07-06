<?php
include_once('security.php');
include('config.php');
include('sidebar.php');

$mensaje = '';
$estilo = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['toggle_mode'])) {
    $dir_subidas = __DIR__ . "/uploads/";
    
    if (!file_exists($dir_subidas)) {
        mkdir($dir_subidas, 0755, true);
    }

    $nombre_original = basename($_FILES["archivo"]["name"]);
    $ext = strtolower(pathinfo($nombre_original, PATHINFO_EXTENSION));
    $permitir_subida = true;
    
    $nombre_final = $nombre_original; 
    $ruta_final = $dir_subidas . $nombre_final;

    if ($DEFENSIVE_MODE) {
        // 1. 🟢 BLUE TEAM: Validación inicial de extensión
        $permitadas = ["jpg", "png", "jpeg", "pdf"];
        if (!in_array($ext, $permitadas)) {
            $permitir_subida = false;
            $mensaje = "❌ Error perimetral: Tipo de extensión (." . htmlspecialchars($ext) . ") no permitido.";
        } else {
            // 2. 🟢 BLUE TEAM: Validación de Magic Bytes reales (MIME)
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime_real = finfo_file($finfo, $_FILES["archivo"]["tmp_name"]);
            finfo_close($finfo);

            $mimes_validos = ["image/jpeg", "image/png", "application/pdf"];
            if (!in_array($mime_real, $mimes_validos)) {
                $permitir_subida = false;
                $mensaje = "❌ BIOMBO DE SEGURIDAD: Firma MIME incorrecta (" . htmlspecialchars($mime_real) . ").";
            }
        }

        // 3. 🟢 BLUE TEAM: Mitigaciones avanzadas OWASP con control de extensión GD
        if ($permitir_subida) {
            $nombre_final = md5(uniqid(rand(), true)) . '.' . $ext;
            $ruta_final = $dir_subidas . $nombre_final;
            $tmp_path = $_FILES["archivo"]["tmp_name"];

            if ($ext === 'jpg' || $ext === 'jpeg') {
                if (!function_exists('imagecreatefromjpeg')) {
                    $permitir_subida = false;
                    $mensaje = "❌ ERROR DEL SISTEMA: La extensión php-gd no está activa en el servidor. Ejecuta 'apt install php-gd'.";
                } else {
                    $img = @imagecreatefromjpeg($tmp_path);
                    if ($img) {
                        imagejpeg($img, $ruta_final, 85); 
                        imagedestroy($img);
                        $mensaje = "✔ [HARDENING ACTIVADO] Evidencia sanitizada con éxito. Se han eliminado los metadatos EXIF/Payloads y se ha renombrado el archivo.";
                        $estilo = "background: #dcfce7; color: #15803d; padding: 15px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;";
                    } else {
                        $permitir_subida = false;
                        $mensaje = "❌ ERROR: Estructura de imagen corrupta o maliciosa.";
                    }
                }
            } elseif ($ext === 'png') {
                if (!function_exists('imagecreatefrompng')) {
                    $permitir_subida = false;
                    $mensaje = "❌ ERROR DEL SISTEMA: La extensión php-gd no está activa para procesar archivos PNG.";
                } else {
                    $img = @imagecreatefrompng($tmp_path);
                    if ($img) {
                        imagepng($img, $ruta_final);
                        imagedestroy($img);
                        $mensaje = "✔ [HARDENING ACTIVADO] Archivo PNG sanitizado y guardado de forma segura.";
                        $estilo = "background: #dcfce7; color: #15803d; padding: 15px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;";
                    } else {
                        $permitir_subida = false;
                        $mensaje = "❌ ERROR: Estructura PNG inválida.";
                    }
                }
            } elseif ($ext === 'pdf') {
                if (move_uploaded_file($tmp_path, $ruta_final)) {
                    $mensaje = "✔ Documento PDF almacenado con identificador seguro no predecible.";
                    $estilo = "background: #dcfce7; color: #15803d; padding: 15px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;";
                } else {
                    $permitir_subida = false;
                }
            }
            
            if ($permitir_subida && file_exists($ruta_final)) {
                chmod($ruta_final, 0644); 
            }
        }
        
        // Si falló alguna validación defensiva, aplicar estilo de error
        if (!$permitir_subida && empty($estilo)) {
            $estilo = "background: #fee2e2; color: #b91c1c; padding: 15px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;";
        }
    } else {
        // 🔴 RED TEAM: Comportamiento original vulnerable (Carga irrestricta)
        if (move_uploaded_file($_FILES["archivo"]["tmp_name"], $ruta_final)) {
            $mensaje = "✔ Incidencia procesada. Archivo adjunto guardado con éxito en el servidor: uploads/" . htmlspecialchars($nombre_final);
            $estilo = "background: #dcfce7; color: #15803d; padding: 15px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;";
        } else {
            $mensaje = "❌ Error en el almacenamiento del laboratorio tradicional.";
            $estilo = "background: #fee2e2; color: #b91c1c; padding: 15px; border-radius: 6px; margin-bottom: 20px; font-size: 14px;";
        }
    }
}
?>

<?php mostrar_banner_seguridad($DEFENSIVE_MODE); ?>

<div style="padding: 30px; font-family: sans-serif;">
    <h1 style="color: #0f172a; margin-top: 0;">🛠️ Centro de Soporte Técnico IT</h1>
    <p style="color: #475569;">Apertura de incidencias técnicas del puesto de trabajo y envío de capturas de error.</p>

    <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 30px 0;">

    <div style="max-width: 600px; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <h3 style="color: #1e3a8a; margin-top: 0; margin-bottom: 20px;">🎫 Registrar Nueva Incidencia</h3>

        <?php if($mensaje): ?>
            <div style="<?php echo $estilo; ?>"><?php echo $mensaje; ?></div>
        <?php endif; ?>

        <form method="POST" action="" enctype="multipart/form-data">
            <label style="display: block; margin-bottom: 8px; font-size: 14px; font-weight: bold; color: #334155;">Descripción de la avería:</label>
            <input type="text" placeholder="Ej: No me abre el programa de facturación" style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box;" required>

            <label style="display: block; margin-bottom: 8px; font-size: 14px; font-weight: bold; color: #334155;">Adjuntar evidencia / Log del sistema:</label>
            <div style="border: 2px dashed #cbd5e1; padding: 25px; text-align: center; border-radius: 6px; background: #f8fafc; margin-bottom: 25px;">
                <input type="file" name="archivo" required style="font-size: 14px;">
            </div>

            <button type="submit" style="background: #1e293b; color: white; padding: 12px 24px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer;">Mandar a Soporte</button>
        </form>
    </div>
</div>

</div> </body> </html>
