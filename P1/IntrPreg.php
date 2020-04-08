<!DOCTYPE html>
<html>
<head>
	<title>Introducir Pregunta</title>
</head>
<body>
	<?php
	$pregunta = $_POST['pregunta'];
	if(trim($pregunta) != ""){
		$dbhost = '127.0.0.1';
		$dbuser = 'root';
		$dbpass = '';
		$db = 'p1';
		$port = '3308';
		$conexion = mysqli_connect($dbhost,$dbuser,$dbpass,$db,$port) or die ("No se pudo establecer conexion con el servidor");
		mysqli_query($conexion,"INSERT INTO pregunta (cod_preg,enunciado) VALUES (NULL,'$pregunta')") or die ("Fallo Introducir datos a tabla");
	}
	else 
	{
		$ErrorText = "Campo Necesario";
	}
	?>
	<form method="post" action="IntrPreg.php">
	Enviar Pregunta: <input type="text" name="pregunta">
	<input type="submit" name="Enviar">
	<br>
	<?php 
	if(trim($ErrorText) != ""):
		print ("<span class='error'>".$ErrorText."</span>");
	endif;
	?>
	</form>
</body>
</html>