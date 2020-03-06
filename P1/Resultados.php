<!DOCTYPE html>
<html>
<head>
	<title>Resultados</title>
</head>
<body>
	<?php
		$dbhost = '127.0.0.1';
		$dbuser = 'usuario';
		$dbpass = '1234';
		$db = 'p1';
		$port = '3308';
		$conexion = mysqli_connect($dbhost,$dbuser,$dbpass,$db,$port);
		mysqli_close($conexion);
		foreach ($_POST as $value) {
			echo $value." ";
		}
	?>
</body>
</html>