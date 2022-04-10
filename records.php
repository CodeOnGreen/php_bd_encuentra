<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Encuentra el premio: Records</title>
</head>
<body>
	<?php
	require ("funciones.php");
	$records = listarRecords();
	?>
	<center>
	<h3>Mejores puntuaciones obtenidas:</h3>
	<table width="600px" style="border: 2px solid; border-color: blue;">
		<tr style="font-weight: bold; background: grey; color: white">
			<td>POS</td>
			<td>FECHA</td>
			<td>PUNTOS</td>
		</tr>
		<?php 
			$posicion = 0;
			foreach ($records as $record) { 
				$posicion++ ;
				?>
				<tr>
					<td><?php echo $posicion ?></td>
					<td><?php echo $record["fecha"] ?></td>
					<td><?php echo $record["puntos"] ?></td>
				</tr>
			<?php } ?>
	</table>
	<p><a href='nueva_partida.php'>Nueva partida</a></p>
	</center>
</body>
</html>