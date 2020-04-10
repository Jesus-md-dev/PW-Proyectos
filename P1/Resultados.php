<!DOCTYPE html>
<html>
<head>
	<meta charset=utf-8>
	<title>Resultados</title>
</head>
<body>
	<?php
	if(isset($_POST['codigo'])) {
		$codigo = $_POST['codigo'];
		$dbhost = 'localhost';
		$dbuser = 'root';
		$dbpass = 'root';
		$db = 'p1';
		$port = '8889';
		$conexion = mysqli_connect($dbhost,$dbuser,$dbpass,$db,$port);
		$resultado = $conexion->query("Select * from Profesor 
			where Profesor.cod_prof like "."'".$codigo."'");
		$val = $resultado->num_rows;
		$resultado->close();
		$conexion->close();
		if($val == 0) {
			echo "El código es incorrecto.";
			echo "<form action ="."'"."Principal.php"."'"."method = "."'"."post"."'".">".
				"<input type = "."'"."submit"."'"." value = "."'"."Volver"."'".">".
				"</form>";
		}
		else {
			echo "¡El código es correcto!";
			// Resto del código
			// ...
		}
	}
	?>
</body>
</html>