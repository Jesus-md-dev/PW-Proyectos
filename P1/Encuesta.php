<!DOCTYPE html>
<html>
<head>
	<meta charset=utf-8>
	<title>Encuesta ESI</title>
</head>
<body>
	<?php
	if($_POST){
		if($_POST['color']=="Dark")
		{
			echo "<body bgcolor=black>";
			echo "<font color=white>";
		}
		else
		{
			echo "<body bgcolor=white>";
			echo "<font color=black>";
		}
	} 
	?>
	<?php 
		$dbhost = '127.0.0.1';
		$dbuser = 'root';
		$dbpass = '';
		$db = 'p1';
		$port = '3308';

		$conexion = new mysqli('127.0.0.1', $dbuser, $dbpass, $db, $port) or die ("No se pudo establecer conexion con el servidor");
	?>
	<form action = "<?php $_PHP_SELF ?>" method = "post"> 
		<input type = "submit" name = "color" value = "Dark">
		<input type = "submit" name = "color" value = "Light">
	</form>
	<form method=post action=Resultados.php>
		<table align=center border = 1>
			<tr align=center>
				<td colspan=3>
					<h2>Código Asignatura</h2>
				</td>
			</tr>
			<tr align=center>
				<td>Titulacion:</td>
				<td>Asignatura:</td>
				<td>Grupo:</td>
			</tr>
	
			<tr align=center>
			<?php
			for($j = 0;$j < 3;$j++):
			if($j == 0)
			{
				$res = $conexion->query("SELECT * FROM Titulacion") or die ("Fallo consulta tabla");
				$nombre = 'titulacion';
			}
			if($j == 1)
			{
				$res = $conexion->query("SELECT * FROM Asignatura") or die ("Fallo consulta tabla");
				$nombre = 'asignatura';
			}
			if($j == 2)
			{
				$res = $conexion->query("SELECT * FROM Grupo") or die ("Fallo consulta tabla");
				$nombre = 'grupo';
			}

			?>
					<td>
			<?php echo "<select name=$nombre>"; ?>
				<?php
				while($row = $res->fetch_assoc())
				{
					if($j == 0)
						echo "<option value=".$row['cod_tit'].">".$row['cod_tit']."</option>";
					if($j == 1)
						echo "<option value=".$row['cod_asig'].">".$row['cod_asig']."</option>";
					if($j == 2)
						echo "<option value=".$row['cod_grup'].">".$row['cod_grup']."</option>";
				}
				?>
			</select>
					</td>
			<?php endfor;?>
			</tr>
		</table>
		<br>
		<table border="1" align="center">
			<tr>
				<td align="center">
					<h2>Información Personal y Academica de los Estudiantes</h2>
				</td>
			</tr>
			<tr>
				<td>
					<ul>
						<li>Edad(años): 
							<input type="radio" name="edad" value="1"><=19
							<input type="radio" name="edad" value="2">20-21
							<input type="radio" name="edad" value="3">22-23
							<input type="radio" name="edad" value="4">24-25
							<input type="radio" name="edad" value="5">>25
						</li>
						<br>
						<li>Sexo: 
							<input type="radio" name="sexo" value="1">Hombre
							<input type="radio" name="sexo" value="2">Mujer
						</li>
						<br>
						<li>Curso más alto en el que están matriculado:
							<?php
							for($i = 1; $i <= 6; $i++){
								$n=$i."º";
								echo "<input type=radio name=calto value=$i>$n";
							}
							?>
						</li>
						<br>
						<li>Curso más bajo en el que están matriculado:
							<?php
							for($i = 1; $i <= 6; $i++){
								$n=$i."º";
								echo "<input type=radio name=cbajo value=$i>$n";
							}
							?>
						</li>
						<br>
						<li>Veces que te has matriculado en esta asignatura: 
							<input type="radio" name="vmat" value="1">1
							<input type="radio" name="vmat" value="2">2
							<input type="radio" name="vmat" value="3">3
							<input type="radio" name="vmat" value="4">>3
						</li>
						<br>
						<li>Veces que te has examinado en esta asignatura: 
							<input type="radio" name="vexaminado" value="1">1
							<input type="radio" name="vexaminado" value="2">2
							<input type="radio" name="vexaminado" value="3">3
							<input type="radio" name="vexaminado" value="4">>3
						</li>
						<br>
						<li>La asignatura me interesa: 
							<input type="radio" name="interes" value="1">Nada
							<input type="radio" name="interes" value="2">Algo
							<input type="radio" name="interes" value="3">Bastante
							<input type="radio" name="interes" value="4">Mucho
						</li>
						<br>
						<li>Hago uso de las Tutorías: 
							<input type="radio" name="tutoria" value="1">Nada
							<input type="radio" name="tutoria" value="2">Algo
							<input type="radio" name="tutoria" value="3">Bastante
							<input type="radio" name="tutoria" value="4">Mucho
						</li>
						<br>
						<li>Dificultad de esta Asignatura: 
							<input type="radio" name="dificultad" value="1">Baja
							<input type="radio" name="dificultad" value="2">Media
							<input type="radio" name="dificultad" value="3">Alta
							<input type="radio" name="dificultad" value="4">Muy alta
						</li>
						<br>
						<li>Calificación esperada: 
							<input type="radio" name="calificacion" value="1">N.P.
							<input type="radio" name="calificacion" value="2">Sus.
							<input type="radio" name="calificacion" value="3">Apro.
							<input type="radio" name="calificacion" value="4">Not.
							<input type="radio" name="calificacion" value="5">Sobr.
							<input type="radio" name="calificacion" value="6">Mat.Hon.
						</li>
						<br>
						<li>Asistencia clase (% de horas lectivas): 
							<input type="radio" name="asistencia" value="1">Menos 50%
							<input type="radio" name="asistencia" value="2">Entre 50% y 80%
							<input type="radio" name="asistencia" value="3">Más de 80%
						</li>
						<br>
					</ul>
				</td>
			</tr>
		</table>
		<br>
		<?php
		$res = mysqli_query($conexion,"SELECT * FROM pregunta") or die ("Fallo consulta tabla");
		?>
		<table border="1" align="center">
			<tr align="center">
				<td>
				</td>
				<?php
				for($j = 1;$j <= 3;$j++){
					echo "<td align=center>";
					echo "COD. PROF.$j";
					echo "</td>";
				}
				?>
			</tr>
			<tr align=center>
				<td>
				</td>
				<?php
				for($j = 1;$j <= 3;$j++){
					$query = $conexion->query("Select * from profesor") or die("Fallo consulta");
					echo "<td>";
					echo "<select>";
					while ($row = $query->fetch_assoc()) 
					{
						
						echo "<option value=".$row['cod_prof'].">".$row['cod_prof']."</option>";

					}
					echo "</select>";
				
						echo "<br>";
					echo "</td>";
				}
				?>
			</tr>
			<?php
			$i = 1;
			while ($row = mysqli_fetch_assoc($res)){
				echo "<tr>";
					echo "<td>";
						echo $i.". ".$row['enunciado']."<br>";
					echo "</td>";
					for($j = 1; $j <= 3; $j++){
						echo "<td  width=210>";
						$n = "pro".$j."pre".$i;
						echo "<input type=radio name=$n value=0 checked>NS";
						echo "<input type=radio name=$n value=1>1";
						echo "<input type=radio name=$n value=2>2";
						echo "<input type=radio name=$n value=3>3";
						echo "<input type=radio name=$n value=4>4";
						echo "<input type=radio name=$n value=5>5";
						echo "</td>";
					}
				echo "</tr>";
				$i++;
			}
			?>
		</table>
		<br>
		<input type="submit" class="center-block" value="Enviar Encuesta">
	</form>
</body>
</html>