<!DOCTYPE html>
<html>
<head>
	<title>Introducir Pregunta</title>
</head>
<body>
	<?php
	if($_POST){
		$dbhost = '127.0.0.1';
		$dbuser = 'root';
		$dbpass = '';
		$db = 'p1';
		$port = '3308';
		$conexion = mysqli_connect($dbhost,$dbuser,$dbpass,$db,$port) or die ("No se pudo establecer conexion con el servidor");
		mysqli_query($conexion,"INSERT INTO pregunta (cod_preg,enunciado) VALUES (NULL,'hola')") or die ("Fallo Introducir datos a tabla");
	}
	?>
	<form method="post" action="IntrPreg.php">
	Enviar Pregunta: <input type="text" name="res">
	</form>
</body>
</html>