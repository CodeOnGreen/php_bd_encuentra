<?php
//Abrir conexión con la bbdd:
$conexion = mysqli_connect("localhost", "root", "", "bd_juego_encuentra"); 

// Comprobamos si se ha conectado:
if ($conexion === false){
    die("ERROR: No he podido conectar: " . mysqli_connect_error());
}
?>