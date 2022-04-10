<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Juego Encuentra el Premio</title>
</head>
<body>
	<?php 
	require ("funciones.php");

	$total_imagenes = 9;

	if (isset($_SESSION["posiciones"])) {
		//Recogemos las posiciones
		$posiciones = $_SESSION["posiciones"];
		//Recogemos el estado de las casillas:
		$estado_casillas = $_SESSION["estado_casillas"];
		//Recogemos la variable intentos:
		$intentos = $_SESSION["intentos"];
		//Recogemos el premio acumulado:
		$acumulado = $_SESSION["acumulado"];
	} else {
		//Creamos el array con las posiciones de las parejas:
		$posiciones = array();
		//Creamos un array para controlar que casillas ya han sido descubiertas:
		$estado_casillas = array(); //0 sin descubrir, 1 ha sido descubierta
		//Metemos los datos en los arrays:
		for ($i=0;$i<$total_imagenes;$i++) {
			$posiciones[] = $i;
			$estado_casillas[] = 0;
		}
		//Cambiamos el contenido del array oosiciones de forma aletoria:
		shuffle($posiciones);

		//Actualizamos en las variables de sesión el estado de los arrays:
		$_SESSION["posiciones"] = $posiciones;
		$_SESSION["estado_casillas"] = $estado_casillas;
		//Establecemos los intentos a 0 y guardamos en una variable de sesión:
		$intentos = 0;
		$_SESSION["intentos"] = $intentos;
		//Establecemos el acumulado a 0 y guardamos en una variable de sesión:
		$acumulado = 0;
		$_SESSION["acumulado"] = $acumulado;
	}

	//Comprobamos si el jugador ha hecho click en alguna imagen (existe una variable GET)
	$fin_partida = false;
	if (isset($_GET["posicion"])) {
		//Ha hecho un intento, lo contabilizamos y actualizamos la variable de sesión:
		$intentos++;
		$_SESSION["intentos"] = $intentos;
		//Obtenemos la posición seleccionada:
		$pos_jugador = $_GET["posicion"];
		//Marcamos esta posición como casilla descubierta en el array estado_casillas y actualizasmo
		//la variable de sesión:
		$estado_casillas[$pos_jugador] = 1;
		$_SESSION["estado_casillas"] = $estado_casillas;
		//Obtenemos de forma aleatoria, el valor del premio entre 1 y 10 para esta tirada:
		$premio = rand(1,10);
		//Comprobamos si encuentra la imagen ganadora (La 7) o la perdedora (la 8):
		switch ($posiciones[$pos_jugador]) {
			case 7:
				//Sumamos el premio al acumulado:
				$acumulado = $acumulado + $premio;
				$fin_partida = true;
				$msg = "Acierto!! <a href='nueva_partida.php'>Nueva partida</a>";
				//Insertamos el resultado de la partida en la BBDD
				insertarPartida($acumulado);
				break;
			case 8:
				//Perdemos todo lo acumulado:
				$acumulado = 0;
				$fin_partida = true;
				$msg = "Fallo!! <a href='nueva_partida.php'>Nueva partida</a>";
				break;
			default:
				//Sumamos el premio al acumulado:
				$acumulado = $acumulado + $premio;
				$msg = "Premio, sigues jugando!";
				break;
		}
		//Guardo el acumulado en la var de sesión:
		$_SESSION["acumulado"] = $acumulado;
	} else {
		//El jugador no ha elegido ninguna imagen:
		$pos_jugador = -1;
	}
	?>


	<center>
		<h3>Encuentra el premio!! Intentos: <?php echo $intentos ?></h3>
		<?php //Si es una tirada el jugador, mostramos el valor del premio:
		if (isset($premio)) { ?>
			<h4>Premio para esta tirada: <?php echo $premio ?></h4>
		<?php } ?>
		<h4>Total acumulado: <?php echo $acumulado ?></h4>
		<h4>RECORD DEL JUEGO: <?php echo obtenerRecord() ?></h4>
		<table>
			<tr>
				<?php for($i=0;$i<$total_imagenes;$i++) { ?>
					<td align="center">
						<?php if ($i == $pos_jugador or $estado_casillas[$i] == 1) { ?>
							<img src="imagenes/dibujo_<?php echo $posiciones[$i] ?>.png" width="100">
						<?php } else { 
							if ($fin_partida==false) { ?>
							<a href="juego.php?posicion=<?php echo $i ?>"><img src="imagenes/interrogacion.png" width="100"></a>
						<?php } else { ?>
							<img src="imagenes/interrogacion.png" width="100">
						<?php }
						} ?>
					</td>
				<?php } ?>
			</tr>
		</table>

		<?php if ($pos_jugador>=0) { ?>
			<p style="color:orange; font-size: 22px"><?php echo $msg ?></p>
		<?php } ?>

		<?php if ($fin_partida == true) { ?>
			<p><a href="records.php">Ver records</a></p>
		<?php } ?>
	</center>
	
</body>
</html>