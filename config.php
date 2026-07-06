<?php
// Conexión limpia usando el nuevo usuario de la intranet
$conn = new mysqli('127.0.0.1', 'global_user', 'CorpPass2026', 'globaltech_db');

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
