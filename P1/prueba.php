<!DOCTYPE html>
<html>
<head>
	<title>Prueba</title>
</head>
<body>
	<?php
	$dbhost = '127.0.0.1';
	$dbuser = 'usuario';
	$dbpass = '1234';
	$db = 'p1';
	$conexion = mysqli_connect($dbhost,$dbuser,$dbpass,$db,'3308') or die ("No se pudo establecer conexion con el servidor");
		echo "Conectado<br>";
	$res = mysqli_query($conexion,"SELECT * FROM preguntas") or die ("Fallo consulta tabla");
	while ($row = mysqli_fetch_assoc($res)) {
		echo $row['pregunta']."<br>";
	}
	mysqli_close($conexion);
	?>
</body>
</html>