<?php
header("Content-Type:application/json");

$conexion = mysqli_connect("localhost", "root", "", "bd_juego_encuentra"); 

// Comprobamos si se ha conectado:
if ($conexion === false){
    die("ERROR: No he podido conectar: " . mysqli_connect_error());
}

$sql = "Select * from partidas order by puntos Desc";
$datos = mysqli_query($conexion, $sql);
$peliculas = array();
while ($fila =  mysqli_fetch_assoc($datos)) {
	$peliculas[] = $fila;
}
mysqli_free_result($datos);
//Pasamos el array a formato JSON:
$json_peliculas = json_encode($peliculas, JSON_UNESCAPED_UNICODE);
//Devolvemos el resultado:
echo $json_peliculas;
?>