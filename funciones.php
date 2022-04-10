<?php

function insertarPartida($puntos) {
	require("bbdd_abrir.php");
	//Montamos la SQL de inserción:
	$fecha = date("Y-m-d H:i:s");
	$sql = "insert into partidas (fecha,puntos) values ('$fecha','$puntos')";
	//Ejecutamos la consulta:
	mysqli_query($conexion,$sql);
	require("bbdd_cerrar.php");
}

function obtenerRecord() {
	require("bbdd_abrir.php");
	$sql = "select max(puntos) as max_puntos from partidas";
	$datos = mysqli_query($conexion, $sql);
	$record = 0;
	if ($fila = mysqli_fetch_assoc($datos)) {
		$record = $fila["max_puntos"];
	}
	//Eliminamos la información de la variable datos (Liberamos de memoria):
	mysqli_free_result($datos);
	require("bbdd_cerrar.php");
	return $record;
}

function listarRecords() {
	require("bbdd_abrir.php");
	$sql = "select * from partidas order by puntos Desc limit 10";
	$datos = mysqli_query($conexion, $sql);
	//Cargamos un array con los datos:
	$records = array();
	while ($fila = mysqli_fetch_assoc($datos)) {
		$records[] = $fila;
	}
	//Eliminamos la información de la variable datos (Liberamos de memoria):
	mysqli_free_result($datos);
	require("bbdd_cerrar.php");
	return $records;
}
?>