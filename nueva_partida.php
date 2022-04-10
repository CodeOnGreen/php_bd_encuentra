<?php
session_start();
//Ahora no puede eliminar todas las variables de sesión, debo mantener la del record:
//session_destroy();
unset($_SESSION["posiciones"]);
unset($_SESSION["estado_casillas"]);
unset($_SESSION["intentos"]);
unset($_SESSION["acumulado"]);
header("Location:juego.php");
?>