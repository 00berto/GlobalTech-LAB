
<?php

if(!isset($_SESSION)) { session_start(); }

include_once('security.php');

if(!isset($_SESSION['usuario'])) { header('Location: login.php'); exit; }

?>

<div style="width: 250px; background: #1e293b; color: white; height: 100vh; position: fixed; top: 0; left: 0; padding-top: 20px; font-family: sans-serif;">

    <div style="padding: 10px 20px; font-size: 20px; font-weight: bold; border-bottom: 1px solid #334155; margin-bottom: 20px;">

        🌐 GlobalTech <br><span style="font-size: 12px; color: #94a3b8;">Intranet Corporativa</span>

    </div>

    

    <div style="padding: 0 20px 20px 20px; font-size: 14px; color: #38bdf8; border-bottom: 1px solid #334155; margin-bottom: 15px;">

        👤 <?php echo $_SESSION['nombre']; ?> <br>

        <span style="font-size: 11px; color: #94a3b8;">Rol: <?php echo strtoupper($_SESSION['rol']); ?></span><br>

        <span style="font-size: 11px; color: #94a3b8;">Puesto: <?php echo strtoupper($_SESSION['puesto'] ?? 'No Asignado'); ?></span>

    </div>

    

    <ul style="list-style: none; padding: 0; margin: 0;">

        <li><a href="dashboard.php" style="display:block; padding:10px 20px; color:#cbd5e1; text-decoration:none;">📊 Dashboard</a></li>

        <li><a href="rrhh.php" style="display:block; padding:10px 20px; color:#cbd5e1; text-decoration:none;">👔 RRHH & Nóminas</a></li>

        <li><a href="documentos.php" style="display:block; padding:10px 20px; color:#cbd5e1; text-decoration:none;">📂 Repositorio Documental</a></li>

        <li><a href="soporte.php" style="display:block; padding:10px 20px; color:#cbd5e1; text-decoration:none;">🛠️ Centro de Soporte</a></li>

        

        <!-- Bloque de Contactos Simplificado -->

        <li style="padding: 15px 20px 5px 20px; font-size: 11px; color: #64748b; text-transform: uppercase; font-weight: bold; letter-spacing: 0.5px;">📞 Contactos</li>

        <li style="padding: 3px 20px; font-size: 12px; color: #94a3b8;">CEO: <span style="color:#cbd5e1; font-family:monospace;">cmendoza@globaltech.com</span></li>

        <li style="padding: 3px 20px; font-size: 12px; color: #94a3b8;">IT: <span style="color:#cbd5e1; font-family:monospace;">asanz@globaltech.com</span></li>

        <li style="padding: 3px 20px; font-size: 12px; color: #94a3b8;">RRHH: <span style="color:#cbd5e1; font-family:monospace;">mrossi@globaltech.com</span>

        <li style="padding: 3px 20px; font-size: 12px; color: #94a3b8;">MKT: <span style="color:#cbd5e1; font-family:monospace;">jmartinez@globaltech.com</span>

</li>

        

        <!-- Filtro restringido exclusivamente al puesto de Soporte Tecnico IT -->

        <?php if(isset($_SESSION['puesto']) && strtolower($_SESSION['puesto']) == 'soporte tecnico it'): ?>

        <li style="margin-top: 15px;">

            <a href="diagnostico.php" style="display:block; padding:12px 20px; color:#38bdf8; text-decoration:none; background:#334155; font-weight:bold; border-left: 4px solid #38bdf8;">

               🖥️ Centro de Diagnóstico

            </a>

        </li>

        <?php endif; ?>

        

        <li><a href="logout.php" style="display:block; padding:12px 20px; color:#ef4444; text-decoration:none; margin-top:40px;">🚪 Cerrar Sesión</a></li>

    </ul>

</div>

<div style="margin-left: 270px; padding: 40px; font-family: sans-serif; background: #f8fafc; min-height: 100vh;">

