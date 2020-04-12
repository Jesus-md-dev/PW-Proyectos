<?php
$dbhost = '127.0.0.1';
$dbuser = 'root';
$dbpass = '';
$db = 'p1';
$port = '3308';
$conexion = mysqli_connect($dbhost,$dbuser,$dbpass,$db,$port) or die ("No se pudo establecer conexion con el servidor");
error_reporting(E_ERROR | E_PARSE);
?>

<?php 
function introducirPregunta($nombre,$nombreTexto,$nombreBoton,$conexion,$idbd,$nombrebd,$tabla)
{
	$valor = $_POST[$nombreTexto];
	$enviarValor = $_POST[$nombreBoton];
	$insert = "INSERT INTO $tabla ($idbd,$nombrebd) VALUES (NULL,'".$valor."')";
	if(isset($enviarValor))
	{
		if(empty($valor))
			$error = "*Campo obligatorio";
		else
		{
			$conexion->query($insert) or die("Insertar $nombre Error");
			$correcto = "$nombre \"$valor\" añadido correctamente";
		}
	}
	echo "<form method=post action=Admin.php>";
	echo "$nombre: ";
	echo "<br>";
	echo "Enunciado: ";
	echo "<input type=text name=$nombreTexto>";
	echo "<input type=submit name=$nombreBoton>";
	echo "<br>";
	if(isset($error))
		echo $error;
	if(isset($correcto))
		echo $correcto;
	echo "</form>";
	echo "<br>";
}

function introducirDato($nombre,$nombreTexto,$nombreBoton,$nombreId,$conexion,$idbd,$nombrebd,$tabla,$tamId)
{
	$valor = $_POST[$nombreTexto];
	$id = $_POST[$nombreId];
	$enviarValor = $_POST[$nombreBoton];
	
	$insert = "insert into $tabla ($idbd,$nombrebd) values ('".$id."','".$valor."')";
	if(isset($enviarValor))
	{
		if(empty($id))
			$error = "*ID obligatorio";
		else
		{
			while(strlen($id) < $tamId)
				$id = "0".$id;
			$select = "select * from $tabla  where($idbd = $id)";
			$res = $conexion->query($select);
			$n = $res->num_rows;
		}
		if(empty($valor))
			$error = "*Nombre obligatorio";
		elseif(strlen($id) > $tamId)
			$error = "*Tamaño del ID superior al limite";
		elseif(strlen($valor) > 50)
			$error = "*Tamaño del ID superior al limite";
		elseif(!ctype_digit($id))
			$error = "*El ID contiene caracteres alfabeticos";
		elseif($n > 0)
			$error = "*Ya existe el ID introducido";
		else
		{
			$conexion->query($insert) or die("Insertar $nombre Error");
			$correcto = "$nombre \"$valor\" añadido correctamente";
		}
	}
	echo "<form method=post action=Admin.php>";
	echo "$nombre: ";
	echo "<br>";
	echo "ID: <input type=text name=$nombreId> ";
	echo "<br>";
	echo "Nombre: <input type=text name=$nombreTexto> ";
	echo "<input type=submit name=$nombreBoton value=Enviar>";
	echo "<br>";
	if(isset($error))
		echo $error;
	if(isset($correcto))
		echo $correcto;
	echo "</form>";
	echo "<br>";
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Introducir Pregunta</title>
</head>
<body>
	
	<?php 
	introducirPregunta("Pregunta","pregunta","enviarPregunta",$conexion,"cod_preg","enunciado","pregunta");
	introducirDato("Titulación","titulacion","enviarTitulacion","idTitulacion",$conexion,"cod_tit","nombre","titulacion",4);
	introducirDato("Asignatura","asignatura","enviarAsignatura","idAsignatura",$conexion,"cod_asig","nombre","asignatura",3);
	introducirDato("Profesor","profesor","enviarProfesor","idProfesor",$conexion,"cod_prof","nombre","profesor",4);
	?>


	<?php 
	$enviarGrupo = $_POST['enviarGrupo'];

	if(isset($enviarGrupo))
	{
		$select = "select * from grupo order by cod_grup desc";
		$res = $conexion->query($select) or die ("Error Grupo");
		$row = $res->fetch_assoc();
		$idGrupo = $row['cod_grup']++;
		if($idGrupo >= 99)
		{
			$errorGrupo = "No se pueden añadir mas grupos";
		}
		else
		{
			$idGrupo++;
			while(strlen($idGrupo) < 2)
					$idGrupo = "0".$idGrupo;
			$insert = "insert into grupo (cod_grup) values (\"$idGrupo\")";
			$conexion->query($insert) or die("Error conexion");
			$correctoGrupo = "Grupo \"$idGrupo\" añadido correctamente";
		}
	}
	?>

	<form method="post" action="Admin.php">
		Grupo: 
		<input type="submit" name="enviarGrupo" value="Añadir Grupo">
	</form>
	<?php 
	if(!empty($errorGrupo) && isset($enviarGrupo))
		echo $errorGrupo;
	if(!empty($correctoGrupo) && isset($enviarGrupo))
		echo $correctoGrupo;
	 ?>
	<br>
	<br>

	<form method="post" action="Admin.php">
		Crear Docencia:
		<br>
		<br>
		Titulación:
		<select name="titulacion">
			<?php 
			$query = $conexion->query("select * from titulacion") or die("Fallo consulta");
			while ($row = $query->fetch_assoc()):
				echo "<option value=".$row['cod_tit'].">".$row['nombre']."</option>";
			endwhile; 
			?>
		</select>
		<br>
		Asignatura:
		<select name="asignatura">
			<?php 
			$query = $conexion->query("select * from asignatura") or die("Fallo consulta");
			while ($row = $query->fetch_assoc()):
				echo "<option value=".$row['cod_asig'].">".$row['nombre']."</option>";
			endwhile; 
			?>
		</select>
		<br>
		Grupo:
		<select name="grupo">
			<?php 
			$query = $conexion->query("select * from grupo") or die("Fallo consulta");
			while ($row = $query->fetch_assoc()):
				echo "<option value=".$row['cod_grup'].">".$row['cod_grup']."</option>";
			endwhile; 
			?>
		</select>
		<br>
		Profesor:
		<select name="profesor">
			<?php 
			$query = $conexion->query("select * from profesor") or die("Fallo consulta");
			while ($row = $query->fetch_assoc()):
				echo "<option value=".$row['cod_prof'].">".$row['nombre']."</option>";
			endwhile; 
			?>
		</select>
		<br>
		<br>
		<input type="submit" name="enviarDocencia" value="Enviar Docencia">
	</form>
</body>
</html>