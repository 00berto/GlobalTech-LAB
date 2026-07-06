<?php
include_once('security.php');
include('config.php');
include('sidebar.php'); 
?>

<?php mostrar_banner_seguridad($DEFENSIVE_MODE); ?>

<div style="padding: 30px; font-family: sans-serif;">
    <h1 style="color: #0f172a; margin-top: 0;">Bienvenido a la Intranet de GlobalTech Solutions</h1>
    <p style="color: #475569;">Último acceso registrado: <?php echo date('Y-m-d H:i:s'); ?></p>

    <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 30px 0;">

    <div style="display: flex; gap: 20px;">
        <div style="flex: 1; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <h3 style="color: #1e3a8a; margin-top: 0;">📢 Comunicado Interno</h3>
            <p style="font-size: 14px; color: #334155;">Recordamos a todo el equipo de ingeniería que la migración del servidor de archivos se completará este fin de semana. Por favor, aseguren sus copias locales.</p>
        </div>
        
        <div style="flex: 1; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
            <h3 style="color: #1e3a8a; margin-top: 0;">⚡ Accesos Rápidos</h3>
            <p style="font-size: 14px; color: #334155;">Ya se encuentran disponibles para su descarga los certificados de retenciones del ejercicio actual en la pestaña de RRHH.</p>
        </div>
    </div>
</div>

</div> </body> </html>
