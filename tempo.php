<?php
echo "<pre>";
echo shell_exec("whoami");
echo "</pre>";$resultado = shell_exec("whoami 2>&1");$resultado = shell_exec("id");
?>
