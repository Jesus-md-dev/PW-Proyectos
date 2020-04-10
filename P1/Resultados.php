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

	//*Docencia
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
	$datos['cod_grup'] = $docrow['cod_grup'];

	$respQuery = "select * from respuesta";
	$respres = $conexion->query($respQuery);
	for($i=1;$i<=6;$i++)
		$voto[$i] = 0;
	while($resprow = $respres->fetch_assoc())
		$voto[$resprow['resp']]++;

	print_r($voto);

	$vNS = array("y" => $voto["1"], "label" => "N.S.");
	$v1 = array("y" => $voto["2"], "label" => "1");
	$v2 = array("y" => $voto["3"], "label" => "2");
	$v3 = array("y" => $voto["4"], "label" => "3");
	$v4 = array("y" => $voto["5"], "label" => "4");
	$v5 = array("y" => $voto["6"], "label" => "5");

	print_r($v1);

	$dataPoints = array();

	for($i = 0; $i < $nopciones; $i++)
	{
		$array = array("y"=> "5", "label"=> "a");
		array_push($dataPoints,$array);
	}
	print_r($dataPoints);

?>

<?php
	if(!isset($atributo)):
	//media

	$media = 0;
	for($i = 2; $i <= 6; $i++)
	{
		$media +=($valorOpcion[$i]*($i-1));
	}

	if($media != 0)
		$media /= $nrespuestas;

	$media = number_format($media,2);

	//mediana
	sort($vectorRespuestas);
	$mediana = $vectorRespuestas[($nrespuestas/2)-1];

	if(($nrespuestas%2)==0)
	{
		$mediana += $vectorRespuestas[($nrespuestas/2)];
		if($mediana != 0)
			$mediana /=2;
	}

	//moda
	$moda = 0;
	$nrepeticiones = 0;
	for($i = 1; $i <= $nopciones; $i++)
	{
		if($valorOpcion[$i] > $nrepeticiones)
		{
			$moda = $i;
			$nrepeticiones = $valorOpcion[$i];
		}
	}
	endif;
?>

<!DOCTYPE html>
<html>
<head>
	<title>Resultados</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">

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
				type: "bar",
				showInLegend: "true",
				indexLabelFontSize: 14,
				indexLabel: "{y}",
				legendText: "{label}",
				indexLabelPlacement: "inside",
				indexLabelFontColor: "#000000",
				indexLabelFontWeight: "bolder",
				dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
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
	<h2 align = center>INFORME DE SATISFACCIÓN CON LA DOCENCIA UNIVERSITARIA.</h2>
		<table align="center" border="1">
			<tr>
				<td>
					<br>
					PROFESOR/A<br>
					ASIGNATURA<br>
					DEPARTAMENTO<br>
					TITULACION<br>
					CENTRO<br>
			 		<br>
				</td>
				<td class="border" align="center">
					<br>
					<?php echo $vector['profesor'][$profesor]; ?> <br>
					<?php echo $vector['asignatura'][$datos['cod_asig']]; ?> <br>
					<?php echo $vector['profesor'][$profesor]; ?> <br>
					<?php echo $vector['titulacion'][$datos['cod_tit']]; ?> <br>
					<?php echo $vector['profesor'][$profesor]; ?> <br>
					 <br>
				</td>
				<td>
					<table>
						<tr>
							<td>
								<br>
								VALORACIÓN GLOBAL PROFESOR/A-ASIGNATURA: <br>
								Planificación de la Enseñanza y Aprendizaje: <br>
								Desarrollo de la Docencia: <br>
								Resultados: Eficacia y Satisfacción: <br>
							</td>
							<td align = "center">
							MD <br>
							<table>
								<tr>
									<td class="border">
										<?php echo $media ?> <br>
										<?php echo $media ?> <br>
										<?php echo $media ?> <br>
										<?php echo $media ?> <br>
									</td>
								</tr>
							</table>
							</td>

							<td align = "center">
							MD Depart.<br>
							<table>
								<tr>
									<td>
										<?php echo $media ?> <br>
										<?php echo $media ?> <br>
										<?php echo $media ?> <br>
										<?php echo $media ?> <br>
									</td>
								</tr>
							</table>
							</td>

							<td align = "center">
							MD Titulación<br>
							<table>
								<tr>
									<td>
										<?php echo $media ?> <br>
										<?php echo $media ?> <br>
										<?php echo $media ?> <br>
										<?php echo $media ?> <br>
									</td>
								</tr>
							</table>
							</td>
							
							<td align="center">
							MD Centro<br>
							<table>
								<tr>
									<td>
										<?php echo $media ?> <br>
										<?php echo $media ?> <br>
										<?php echo $media ?> <br>
										<?php echo $media ?> <br>
									</td>
								</tr>
							</table>
							</td>
							
							<td align = "center">
							MD UCA<br>
							<table>
								<tr>
									<td>
										<?php echo $media ?> <br>
										<?php echo $media ?> <br>
										<?php echo $media ?> <br>
										<?php echo $media ?> <br>
									</td>
								</tr>
							</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
					<table border=1px>
						<tr>
							<td></td>
							<td align="center">N</td>
							<td>MD</td>
							<td>DT</td>
						</tr>
						<?php $i=1; ?>
						<?php foreach ($vector['pregunta'] as $preg): ?>
						<tr>
							<td>
								<?php 
								echo $i.". ".$preg;
								$i++; 
								?>
							</td>
							<td><?php echo $media; ?></td>
							<td><?php echo $media; ?></td>
							<td><?php echo $media; ?></td>
						</tr>
						<?php endforeach; ?>
					</table>
				</td>
				<td>
					<div id="chartContainer" style="height: 250px; width: 100%;"></div>
					<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
				</td>
			</tr>
		</table>
	<?php $conexion->close();?>
</body>
</html>  