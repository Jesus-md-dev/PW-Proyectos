<?php
	error_reporting(E_ERROR | E_PARSE);
	$dbhost = '127.0.0.1';
	$dbuser = 'root';
	$dbpass = '';
	$db = 'p1';
	$port = '3308';
	$conexion = new mysqli($dbhost,$dbuser,$dbpass,$db,$port) or die ("No se pudo establecer conexion con el servidor");
	//Valores

	$query = $conexion->query("Select * from pregunta") or die("Fallo consulta preg");
	while ($row = $query->fetch_assoc())
		$vector['pregunta'][$row['cod_preg']] = $row['enunciado'];

	$query = $conexion->query("Select * from profesor") or die("Fallo consulta prof");
	while ($row = $query->fetch_assoc())
		$vector['profesor'][$row['cod_prof']] = $row['nombre'];


	$query = $conexion->query("Select * from titulacion") or die("Fallo consulta tit");
	while ($row = $query->fetch_assoc())
		$vector['titulacion'][$row['cod_tit']] = $row['nombre'];

	$query = $conexion->query("Select * from asignatura") or die("Fallo consulta asig");
	while ($row = $query->fetch_assoc())
		$vector['asignatura'][$row['cod_asig']] = $row['nombre'];

	$query = $conexion->query("Select * from grupo") or die("Fallo consulta gr");
	while ($row = $query->fetch_assoc())
		$vector['grupo'][$row['cod_grup']] = $row['cod_grup'];

	$vector['edad'] = array("1" => "<=19", "2" => "20-21", "3" => "21-23", "4" => "
		24-25", "5" => ">25");
	$nTipo['edad'] = "edad";

	$vector['sexo'] = array("1" => "Hombre", "2" => "Mujer");
	$nTipo['sexo'] = "sexo";

	$vector['alto'] = array("1" => "1º", "2" => "2º", "3" => "3º", "4" => "4º", "5" => "5º", "6" => "6º");
	$nTipo['alto'] = "curso_sup";

	$vector['bajo'] = array("1" => "1º", "2" => "2º", "3" => "3º", "4" => "4º", "5" => "5º", "6" => "6º");
	$nTipo['bajo'] = "curso_inf";

	$vector['matriculado'] = array("1" => "1", "2" => "2", "3" => "3", "4" => ">3");
	$nTipo['matriculado'] = "n_matri";

	$vector['examinado'] = array("1" => "1", "2" => "2", "3" => "3", "4" => ">3");
	$nTipo['examinado'] = "n_exam";

	$vector['interes'] = array("1" => "Nada", "2" => "Algo", "3" => "Bastante", "4" => "Mucho");
	$nTipo['interes'] = "interes";

	$vector['tutorias'] = array("1" => "Nada", "2" => "Algo", "3" => "Bastante", "4" => "Mucho");
	$nTipo['tutorias'] = "tutorias";

	$vector['dificultad'] = array("1" => "Baja", "2" => "Media", "3" => "Alta", "4" => "Muy alta");
	$nTipo['dificultad'] = "dificultad";

	$vector['calificacion'] = array("1" => "No Presentado", "2" => "Suspenso", "3" => "Aprobado", "4" => "Notable", "5" => "Sobresaliente", "6" => "Matricula de Honor");
	$nTipo['calificacion'] = "calif";

	$vector['asistencia'] = array("1" => "Menos 50%", "2" => "Entre 50% y 80%", "3" => "Más de 80%");
	$nTipo['asistencia'] = "asist";

	$vector['respuesta'] = array("1"=> "N.S.", "2" => "1", "3" => "2", "4" => "3", "5" => "
		4", "6" => "5");

	$QDocencia = "false";
	$QEncuesta = "false";

	$valorNulo = "0";
	$unAtributo = "global";

	$profesor = "0001";

?>
<?php 
	function estWhere($profesor,$conexion,$where)
	{
		$busqueda = $conexion->query("select resp from respuesta where( cod_prof = $profesor and resp != 1  $where )") or die ("estWhere");
		$datos['num']=$busqueda->num_rows;
		$datos['total'] = 0;
		$datos['desTipica'] = 0;
		$datos['media'] = 0;
		if($datos['num'] > 0):
			while ($valor = $busqueda->fetch_assoc()):
				$datos['total'] += ($valor['resp']-1);
				$desTipica[] = ($valor['resp']-1);
			endwhile;
			$datos['media'] = $datos['total']/$datos['num'];
			foreach ($desTipica as $v)
				$datos['desTipica'] += pow($v-$datos['media'],2);
			$datos['desTipica'] = sqrt($datos['desTipica']/$datos['num']);
		endif;
		return $datos;
			
	}

	function tablaPorcentajes($vector,$tipo,$string,$profesor,$titulacion,$asignatura,$conexion)
	{
		$n = count($vector);
		$select = $tipo;
		$tabla = "Encuesta";$where = " where(";$wherecond = "false";
		$where = "id_doc in (select id_doc from docencia where (cod_tit = $titulacion and cod_asig = $asignatura and id_doc in (select id_doc from profesordocencia where (cod_prof = $profesor))))";
		$query = "select $select from $tabla where($where)";
		$res = $conexion->query($query) or die("tablaPorcentajes");
		for($i = 1; $i <= $n; $i++)
			$porcetajes[$i] = 0;
		$nrows = $res->num_rows;
		while($row = $res->fetch_assoc())
			$porcetajes[$row[$tipo]]++;
		for($i = 1; $i <= $n; $i++):
			if($porcetajes[$i] != 0):
				$porcetajes[$i] = ($porcetajes[$i]/$nrows)*100;
			endif;
		endfor;
		echo "<table align=center border=1px width=900px>";
			echo "<tr>";
				echo "<td></td>";
				foreach ($vector as $nombre)
					echo "<td align=center>$nombre</td>";
			echo "</tr>";
			echo "<tr>";
				echo "<td align=center>$string</td>";
				foreach ($porcetajes as $porcenjate)
					echo "<td align=center>$porcenjate%</td>";
			echo "</tr>";
		echo "</table>";
		echo "<br>";
	}
?>
<?php 
		
?>
<?php

	$where = $profesor;
	$profdocQuery = "select id_doc from profesordocencia where (cod_prof = $where)";
	$profdocres = $conexion->query($profdocQuery);
	$profdocrow = $profdocres->fetch_assoc();
	$datos['id_doc'] = $profdocrow['id_doc'];

	$where = $datos['id_doc'];
	$docQuery = "select * from docencia where (id_doc = $where)";
	$docres = $conexion->query($docQuery);
	$docrow = $docres->fetch_assoc();
	$datos['cod_tit'] = $docrow['cod_tit'];
	$datos['cod_asig'] = $docrow['cod_asig'];

	if($_POST['titulacion']!=0)
		$ctit = $_POST['titulacion'];
	else
		$ctit = $datos['cod_tit'];
	if($_POST['asignatura']!=0)
		$casig = $_POST['asignatura'];
	else 
		$casig = $datos['cod_asig'];
	$p = "select id_doc from docencia where(cod_asig = $casig and cod_tit = $ctit)";
	$res = $conexion->query($p);
	if($res->num_rows <= 0)
	{		
		$nasig = $vector['asignatura'][$casig];
		$ntit = $vector['titulacion'][$ctit];
		$error = "*No existe la asignatura $nasig de la titulacion $ntit";
	}
	else
	{
		$q = "select * from profesordocencia where (cod_prof = $profesor and id_doc in ($p))";
		$res = $conexion->query($q);
		$nasig = $vector['asignatura'][$casig];
		$ntit = $vector['titulacion'][$ctit];
		if($res->num_rows <= 0)
			$error = "*El Profesor $profesor no pertenece a la asignatura $nasig de la titulacion $ntit";
		else
		{
			$datos['cod_tit'] = $ctit;
			$datos['cod_asig'] = $casig;
		}
	}


	








	$where = "and id_en in (select id_en from encuesta where ( id_doc in (select id_doc from docencia where (cod_tit = $datos[cod_tit] and cod_asig = $datos[cod_asig]))))";
	$datosProfesor = estWhere($profesor,$conexion,$where);

	$where = "and id_en in (select id_en from encuesta where (cod_prof = $profesor and id_doc in (select id_doc from docencia where (cod_tit = $datos[cod_tit]))))";
	$datosTitulacion = estWhere($profesor,$conexion,$where);

	$where = "";
	$datosTodos = estWhere($profesor,$conexion,$where);

	$mediaProfesor = array("y" => number_format($datosProfesor['media'],2), "label" => "Asignatura");
	$mediaTitulacion = array("y" => number_format($datosTitulacion['media'],2), "label" => "Titulación");
	$mediaTodos = array("y" => number_format($datosTodos['media'],2), "label" => "UCA");

	$amedia = array();

	array_push($amedia,$mediaProfesor);
	array_push($amedia,$mediaTitulacion);
	array_push($amedia,$mediaTodos);


?>

<!DOCTYPE html>
<html>
<head>
	<title>Resultados</title>
	<style>

	.column {
	  float: left;
	  width: 50%;
	}

	</style>

	<script>

		window.onload = function () {
		 
		var chart = new CanvasJS.Chart("chartContainer", {
			exportEnabled: true,
			animationEnabled: true,
			theme: "light1",
			data: [{
				type: "column",
				indexLabelFontSize: 14,
				indexLabel: "{y}",
				indexLabelPlacement: "inside",
				indexLabelFontColor: "#000000",
				indexLabelFontWeight: "bolder",
				dataPoints: <?php echo json_encode($amedia, JSON_NUMERIC_CHECK); ?>
			}]
		});
		chart.render();
		}

	</script>

	<style type="text/css">
		body{
			background: lightyellow;
			color: black;
			text-shadow: 1px white;
			font-family: Helvetica;
		}

		table{
			table-layout: auto;
		}

		tr{
			table-layout: auto;
		}

		td{
			table-layout: auto;
		}

		td.border {
			border: 1px solid black;
		}


		.content-loader tr td {
			white-space: nowrap;
		}

	</style>
</head>

<body>
	<form method="post" action="">
		<input type="submit" value="Volver al Inicio">
	</form>
	<form method="post" action="ResPersonalizado.php">
		<input type="hidden" name="idprofesor" value=<?php echo $profesor; ?>>
		<input type="submit" value="Ir a Resultados Personalizados">
	</form>
	<h2 align = center>INFORME DE SATISFACCIÓN CON LA DOCENCIA UNIVERSITARIA.</h2>
		<table align="center" width=900px>
			<tr>
				<td width=100>PROFESOR/A: </td>
				<td><?php echo $vector['profesor'][$profesor]; ?></td>
				<td ></td>
				<td align="center">MD Asignatura</td>
				<td align="center">MD Titulación</td>
				<td align="center">MD UCA</td>
			</tr>
			<tr>
				<td>ASIGNATURA: </td>
				<td ><?php echo $vector['asignatura'][$datos['cod_asig']]; ?> </td>
				<td width=150>&nbsp;Valoración Global:</td>
				<td align="center"><?php echo number_format($datosProfesor['media'],2) ?> </td>
				<td align="center"><?php echo number_format($datosTitulacion['media'],2) ?> </td>
				<td align="center"><?php echo number_format($datosTodos['media'],2) ?> </td>
			</tr>
			<tr>
				<td>TITULACION: </td>
				<td><?php echo $vector['titulacion'][$datos['cod_tit']]; ?></td>
			</tr>
			<tr>
				<td>
					<form method="post" action="Resultados.php">
						<?php $q = "Select * from titulacion where(cod_tit in (select cod_tit from docencia where(id_doc in (select id_doc from profesordocencia where (cod_prof = $profesor)))))";
						?>
						<select name = titulacion>
							<option value="0">Elegir Titulación</option>
							<?php 
							$query = $conexion->query($q) or die("Fallo consulta");
							while ($row = $query->fetch_assoc()):
								echo "<option value=".$row['cod_tit'].">".$row['nombre']."</option>";
							endwhile; 
							?>
						</select>
						<?php $q = "Select * from asignatura where(cod_asig in (select cod_asig from docencia where(id_doc in (select id_doc from profesordocencia where (cod_prof = $profesor)))))";
						?>
						<select name = asignatura>
							<option value="0">Elegir Asignatura</option>
							<?php 
							$query = $conexion->query($q) or die("Fallo consulta");
							while ($row = $query->fetch_assoc()):
								echo "<option value=".$row['cod_asig'].">".$row['nombre']."</option>";
							endwhile; 
							?>
						</select>
						<br>
						<input type="submit" name="actualizar" value="Actualizar">
					</form>
				</td>
			</tr>
			<?php if(isset($error)): ?>
			<tr>
				<td colspan="6">
					<p style="color:red"><?php echo $error; ?></p>
				</td>
			</tr>
			<?php endif; ?>
			<tr>
				<td colspan="2" align="center">
					<table border=1px width="400px">
						<tr>
							<td></td>
							<td align="center">N</td>
							<td align="center">MD</td>
							<td align="center">DT</td>
						</tr>
						<?php $i=1; $t =  $datos['cod_tit']; $a =  $datos['cod_asig'];?>
						<?php foreach ($vector['pregunta'] as $preg): ?>
						<tr>
							<td>
								<?php 
								echo $i.". ".$preg;
								$i++;
								$p = array_search($preg, $vector['pregunta']);
								$where = "and cod_preg = $p and id_en in (select id_en from encuesta where (cod_prof = $profesor and id_doc in (select id_doc from docencia where (cod_tit = $t and cod_asig = $a))))";
								$datosPregunta = estWhere($profesor,$conexion,$where);
								//estPregunta($profesor,$conexion,array_search($preg, $vector['pregunta']));
								if($datosPregunta['total'] == 0)
									$media = 0;
								else
									$media = $datosPregunta['total'] / $datosPregunta['num'];
								?>
							</td>
							<td align="center"><?php echo $datosPregunta['num']; ?></td>
							<td align="center"><?php echo number_format($datosPregunta['media'],2); ?></td>
							<td align="center"><?php echo number_format($datosPregunta['desTipica'],2); ?></td>
						</tr>
						<?php endforeach; ?>
					</table>
				</td>
				<td colspan="6">
					<h3 align="center">Media</h3>
					<div id="chartContainer" style="height: 250px; width: 100%;"></div>
					<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
				</td>
			</tr>
		</table>
		<br>
		<?php 
		tablaPorcentajes($vector['edad'],$nTipo['edad'],"Edad (años)",$profesor,$datos['cod_tit'],$datos['cod_asig'],$conexion);
		tablaPorcentajes($vector['sexo'],$nTipo['sexo'],"Sexo",$profesor,$datos['cod_tit'],$datos['cod_asig'],$conexion); 
		tablaPorcentajes($vector['alto'],$nTipo['alto'],"Curso más alto en el que están matriculados",$profesor,$datos['cod_tit'],$datos['cod_asig'],$conexion); 
		tablaPorcentajes($vector['bajo'],$nTipo['bajo'],"Curso más bajo en el que están matriculados",$profesor,$datos['cod_tit'],$datos['cod_asig'],$conexion); 
		tablaPorcentajes($vector['interes'],$nTipo['interes'],"La asignatura me interesa ",$profesor,$datos['cod_tit'],$datos['cod_asig'],$conexion); 
		tablaPorcentajes($vector['tutorias'],$nTipo['tutorias'],"Hago uso de las Tutoría",$profesor,$datos['cod_tit'],$datos['cod_asig'],$conexion);
		tablaPorcentajes($vector['dificultad'],$nTipo['dificultad'],"Dificultad de esta Asignatura",$profesor,$datos['cod_tit'],$datos['cod_asig'],$conexion); 
		tablaPorcentajes($vector['calificacion'],$nTipo['calificacion'],"Calificación esperada",$profesor,$datos['cod_tit'],$datos['cod_asig'],$conexion); 
		tablaPorcentajes($vector['asistencia'],$nTipo['asistencia'],"Asistencia clase (% de horas lectivas)",$profesor,$datos['cod_tit'],$datos['cod_asig'],$conexion); 
		?>
	<?php $conexion->close();?>
</body>
</html>  