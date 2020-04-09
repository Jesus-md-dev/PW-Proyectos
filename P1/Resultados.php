<?php
	error_reporting(E_ERROR | E_PARSE);
	$dbhost = '127.0.0.1';
	$dbuser = 'root';
	$dbpass = '';
	$db = 'p1';
	$port = '3308';
	$conexion = new mysqli($dbhost,$dbuser,$dbpass,$db,$port) or die ("No se pudo establecer conexion con el servidor");

	//Valores
	$typeChart = $_POST['typeChart'];
	$valorChart = array("1" => "column", "2" => "bar", "3" => "pie", "4" => "doughnut");
	$valorGrafica = array("1" => "Columnas", "2" => "Barras", "3" => "Circular", "4" => "Donut");

	//$cPregunta = $_POST['cPregunta'];
	$pregunta = $_POST['pregunta'];

	$cProfesor = $_POST['cProfesor'];
	$profesor = $_POST['profesor'];

	$cTitulacion = $_POST['cTitulacion'];
	$titulacion = $_POST['titulacion'];

	$cAsignatura = $_POST['cAsignatura'];
	$asignatura = $_POST['asignatura'];

	$cGrupo = $_POST['cGrupo'];
	$grupo = $_POST['grupo'];

	$tEdad = "Edad";
	$cEdad = $_POST['cEdad'];
	$edad = $_POST['edad'];
	$valorEdades = array("1" => "<=19", "2" => "20-21", "3" => "21-23", "4" => "
		24-25", "5" => ">25");

	$cSexo = $_POST['cSexo'];
	$sexo = $_POST['sexo'];
	$valorSexo = array("1" => "Hombre", "2" => "Mujer");

	$cAlto = $_POST['cAlto'];
	$alto = $_POST['alto'];
	$valorAlto = array("1" => "1º", "2" => "2º", "3" => "3º", "4" => "4º", "5" => "5º", "6" => "6º");

	$cBajo = $_POST['cBajo'];
	$bajo = $_POST['bajo'];
	$valorBajo = array("1" => "1º", "2" => "2º", "3" => "3º", "4" => "4º", "5" => "5º", "6" => "6º");

	$cMatriculado = $_POST['cMatriculado'];
	$matriculado = $_POST['matriculado'];
	$valorMatriculado = array("1" => "1", "2" => "2", "3" => "3", "4" => ">3");

	$cExaminado = $_POST['cExaminado'];
	$examinado = $_POST['examinado'];
	$valorExaminado = array("1" => "1", "2" => "2", "3" => "3", "4" => ">3");

	$cInteres = $_POST['cInteres'];
	$interes = $_POST['interes'];
	$valorInteres = array("1" => "Nada", "2" => "Algo", "3" => "Bastante", "4" => "Mucho");

	$cTutorias = $_POST['cTutorias'];
	$tutorias = $_POST['tutorias'];
	$valorTutorias = array("1" => "Nada", "2" => "Algo", "3" => "Bastante", "4" => "Mucho");

	$cDificultad = $_POST['cDificultad'];
	$dificultad = $_POST['dificultad'];
	$valorDificultad = array("1" => "Baja", "2" => "Media", "3" => "Alta", "4" => "Muy alta");

	$cCalificacion = $_POST['cCalificacion'];
	$calificacion = $_POST['calificacion'];
	$valorCalificacion = array("1" => "No Presentado", "2" => "Suspenso", "3" => "Aprobado", "4" => "Notable", "5" => "Sobresaliente", "6" => "Matricula de Honor");

	$cAsistencia = $_POST['cAsistencia'];
	$asistencia = $_POST['asistencia'];
	$valorAsistencia = array("1" => "Menos 50%", "2" => "Entre 50% y 80%", "3" => "Más de 80%");

	$valorPreguntas = array("0"=> "N.S.", "1" => "1", "2" => "2", "3" => "3", "4" => "
		4", "5" => "5");
?>

<?php

function insertarWhereName(&$wherecond,&$where,$value,$id,$type,$string,&$name)
{
	if($wherecond == "true")
		$where = $where." and ";
	else
		$wherecond = "true";
	$where = $where."$type = $id";
	$name = $name." | $string: ".$value[$id];
}

function insertarWhere(&$wherecond,&$where,$id,$type)
{
	if($wherecond == "true")
		$where = $where." and ";
	else
		$wherecond = "true";
	$where = $where."$type = $id";
}

function selectContent($title,$name,$check,$vector)
{
	echo "<input type=checkbox name=$check>";
	echo " ".$title.": ";
	echo "<select name=$name>";
	 for($i=1; $i <= count($vector); $i++) {
		echo "<option value=".$i.">".$vector[$i]."</option>";
	}
	echo "</select>";
	echo "<br>";
} 

?>

<?php
	$buscar = $_POST['Buscar'];
	if(isset($buscar))
		$cBuscar = "true";
?>

<?php

if($cBuscar == "true"):
	if($pregunta == "-1")
		$nombrePregunta = "Todas";
	else
	{
		$query = $conexion->query("Select * from pregunta where cod_preg = ".$pregunta) or die("Fallo consulta Pregunta");
		$result = $query->fetch_assoc();
		$nombrePregunta = $result['enunciado'];
	}

	$name = "Pregunta: ".$nombrePregunta;

	if($cProfesor == "on"):
		$resp = $conexion->query("select * from profesor where cod_prof = $profesor") or die ("Fallo Profesor");
		$fila = $resp->fetch_assoc();
		$name = $name." | Profesor: ".$fila['nombre'];
	endif;

	if($cTitulacion == "on"):
		$resp = $conexion->query("select * from titulacion where cod_tit = $titulacion") or die ("Fallo titulacion");
		$fila = $resp->fetch_assoc();
		$name = $name." | Titulación: ".$fila['nombre'];
	endif;

	if($cAsignatura == "on"):
		$resp = $conexion->query("select * from asignatura where cod_asig = $asignatura") or die ("Fallo asignatura");
		$fila = $resp->fetch_assoc();
		$name = $name." | Asignatura: ".$fila['nombre'];
	endif;

	if($cGrupo == "on"):
		$resp = $conexion->query("select * from grupo where cod_grup = $grupo") or die ("Fallo Grupo");
		$fila = $resp->fetch_assoc();
		$name = $name." | Grupo: ".$fila['cod_grup'];
	endif;

	$select = "id_doc";
	$tabla = "docencia";
	$where = " where(";
	$wherecond = "false";
	$docQuery = "select ".$select." from ".$tabla;

	//*Docencia
	if($cTitulacion == "on" || $cAsignatura == "on" || $cGrupo == "on")
	{
		$QDocencia = "on";
		if($cTitulacion == "on")
			insertarWhere($wherecond,$where,$titulacion,"cod_tit");
		if($cAsignatura == "on")
			insertarWhere($wherecond,$where,$asignatura,"cod_asig");
		if($cGrupo == "on")
			insertarWhere($wherecond,$where,$grupo,"cod_grup");
		if($wherecond == "true")
			$docQuery = $docQuery.$where.")";
		
		if($cProfesor == "on")
		{
			$q = "select * from profesordocencia where (cod_prof = $profesor and id_doc in ($docQuery))";
			echo $q."<br>";
			$res = $conexion->query($q);
			if($res->num_rows <= 0):
				$puedeMostrar = "false";
				$error = "El Profesor $profesor no pertenece a: <br>";
				if($cTitulacion == "on"):
					$query = $conexion->query("Select * from titulacion where (cod_tit = $titulacion)") or die("Fallo consulta");
					$row = $query->fetch_assoc();
					$error = $error."<br>-Titulación: $row[nombre] ";
				endif;
				if($cAsignatura == "on"):
					$query = $conexion->query("Select * from asignatura where (cod_asig = $asignatura)") or die("Fallo consulta");
					$row = $query->fetch_assoc();
					$error = $error."<br>-Asignatura: $row[nombre] ";
				endif;
				if($cGrupo == "on")
					$error = $error."<br>-Grupo: $grupo ";
			endif;			
		}
	}

	//Docencia

	$select = "*";
	$where = " where(";
	$wherecond = "false";
	//*Encuesta

	if($cEdad=="on" || $cSexo=="on" || $cAlto == "on" || $cBajo == "on" || $cMatriculado == "on" || $cExaminado == "on"  || $cInteres == "on" || $cTutorias == "on" || $cDificultad == "on" || $cCalificacion == "on" || $cAsistencia == "on" || $QDocencia = "on")
	{
		$QEncuesta = "on";
		$tabla = "Encuesta";
		$id_enQuery = "select id_en from ".$tabla;

		if($cEdad=="on")
			insertarWhereName($wherecond,$where,$valorEdades,$edad,"edad","Edad",$name);

		if($cSexo=="on")
			insertarWhereName($wherecond,$where,$valorSexo,$sexo,"sexo","Sexo",$name);

		if($cAlto=="on")
			insertarWhereName($wherecond,$where,$valorAlto,$alto,"curso_sup","Curso más alto",$name);

		if($cBajo=="on")
			insertarWhereName($wherecond,$where,$valorBajo,$bajo,"curso_inf","Curso más bajo",$name);

		if($cMatriculado=="on")
			insertarWhereName($wherecond,$where,$valorMatriculado,$matriculado,"n_matri","Veces matriculado",$name);

		if($cExaminado=="on")
			insertarWhereName($wherecond,$where,$valorExaminado,$examinado,"n_exam","Veces examinado",$name);

		if($cInteres=="on")
			insertarWhereName($wherecond,$where,$valorInteres,$interes,"interes","Interés",$name);

		if($cTutorias=="on")
			insertarWhereName($wherecond,$where,$valorTutorias,$tutorias,"tutorias","Tutorías",$name);

		if($cDificultad=="on")
			insertarWhereName($wherecond,$where,$valorDificultad,$dificultad,"dificultad","Dificultad",$name);

		if($cCalificacion=="on")
			insertarWhereName($wherecond,$where,$valorCalificacion,$calificacion,"calif","Calificacion",$name);

		if($cAsistencia=="on")
			insertarWhereName($wherecond,$where,$valorAsistencia,$asistencia,"asist","Asistencia",$name);
		if($QEncuesta == "on"):
			if($wherecond == "true")
				$where = $where." and ";
			else
				$wherecond = "true";
			$where = $where."id_doc in (".$docQuery.")";
		endif;
		if($wherecond == "true")
			$id_enQuery = $id_enQuery.$where.")";
	}

	//Encuesta

	$nombrePregunta ="Todas";
	$select = "*";
	$where = " where(";
	$wherecond = "false";

	//*Respuesta

	$tabla = "respuesta";
	$Query = "select ".$select." from ".$tabla;

	if($pregunta != "-1")
		insertarWhere($wherecond,$where,$pregunta,"cod_preg",);

	if($cProfesor == "on")
		insertarWhere($wherecond,$where,$profesor,"cod_prof",);

	if($QEncuesta == "on"):
		if($wherecond == "true")
			$where = $where." and ";
		else
			$wherecond = "true";
		$where = $where."id_en in (".$id_enQuery.")";
	endif;

	if($wherecond == "true")
		$Query = $Query.$where.")";
	$respuestas = $conexion->query("$Query") or die("Fallo respuestas");
	$nrespuestas = $respuestas->num_rows;
	//Respuesta

	$nopciones = 6;

	for($i = 0; $i < $nopciones; $i++)
	{
		$valorOpcion[$i] = 0;
	}

	while($respFila = $respuestas->fetch_assoc()):
		$vectorRespuestas[] = $respFila['resp'];
		$valorOpcion[$respFila['resp']]++;
	endwhile;

	$dataPoints = array();

	for($i = 0; $i < $nopciones; $i++)
	{
		$array = array("y"=> $valorOpcion[$i], "label"=> $valorPreguntas[$i]);
		array_push($dataPoints,$array);
	}
endif;
	echo "Docencia: ".$docQuery."<br>";
	echo "Encuesta: ".$id_enQuery."<br>";
	echo "Respuesta: ".$Query."<br>";
?>

<?php
	//media
	$media = 0;
	for($i = 1; $i <= 5; $i++)
	{
		$media +=( $valorOpcion[$i]*$i);
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
	for($i = 0; $i < $nopciones; $i++)
	{
		if($valorOpcion[$i] > $nrepeticiones)
		{
			$moda = $i;
			$nrepeticiones = $valorOpcion[$i];
		}
	}
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
				type: "<?php echo "$valorChart[$typeChart]" ?>",
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
		//chart.data[0].set("type","pie",false)
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
	</style>
</head>

<body>
<div>
	<h1 align = center>Resultados de las Encuestas</h1>
	<div class="column">
		
		<form action="Resultados.php" method="post">
			<h2>Opciones:</h2>
			Tipo de gráfico: 
			<select name=typeChart>;
			 <?php for($i=1; $i <= count($valorGrafica); $i++) {
				echo "<option value=".$i.">".$valorGrafica[$i]."</option>";  
			} ?>
			</select>
			<br>

			<!--<input type="checkbox" name="cPregunta">-->
			Pregunta: <select name=pregunta>
			<option value="-1">Todas</option>
			<?php 
			$query = $conexion->query("Select * from pregunta") or die("Fallo consulta");
			while ($row = $query->fetch_assoc()):
				echo "<option value=".$row['cod_preg'].">".$row['enunciado']."</option>";
			endwhile;
			?>
			</select>
			<br>
			<h3>Filtros:</h3>
			<input type="checkbox" name="cProfesor">
			Profesor: <select name=profesor>
			<?php 
			$query = $conexion->query("Select * from profesor") or die("Fallo consulta");
			while ($row = $query->fetch_assoc()):
				echo "<option value=".$row['cod_prof'].">".$row['nombre']."</option>";
			endwhile; 
			?>
			</select>
			<br>

			<input type="checkbox" name="cTitulacion">
			Titulación: <select name=titulacion>
			<?php 
			$query = $conexion->query("Select * from titulacion") or die("Fallo consulta");
			while ($row = $query->fetch_assoc()):
				echo "<option value=".$row['cod_tit'].">".$row['nombre']."</option>";
			endwhile; 
			?>
			</select>
			<br>

			<input type="checkbox" name="cAsignatura">
			Asignatura: <select name=asignatura>
			<?php 
			$query = $conexion->query("Select * from asignatura") or die("Fallo consulta");
			while ($row = $query->fetch_assoc()):
				echo "<option value=".$row['cod_asig'].">".$row['nombre']."</option>";
			endwhile; 
			?>
			</select>
			<br>

			<input type="checkbox" name="cGrupo">
			Grupo: <select name=grupo>
			<?php 
			$query = $conexion->query("Select * from grupo") or die("Fallo consulta");
			while ($row = $query->fetch_assoc()):
				echo "<option value=".$row['cod_grup'].">".$row['cod_grup']."</option>";
			endwhile; 
			?>
			</select>
			<br>
			<?php 

			selectContent("Edad","edad","cEdad",$valorEdades);
			selectContent("Sexo","sexo","cSexo",$valorSexo);
			selectContent("Curso más alto","alto","cAlto",$valorAlto);
			selectContent("Curso más bajo","bajo","cBajo",$valorBajo);
			selectContent("Veces matriculado","matriculado","cMatriculado",$valorMatriculado);
			selectContent("Veces examinado","examinado","cExaminado",$valorExaminado);
			selectContent("Interés","interes","cInteres",$valorInteres);
			selectContent("Uso de tutorías","tutorias","cTutorias",$valorTutorias);
			selectContent("Dificultad","dificultad","cDificultad",$valorDificultad);
			selectContent("Calificación esperada","calificacion","cCalificacion",$valorCalificacion);
			selectContent("Asistencia","asistencia","cAsistencia",$valorAsistencia);

			?>
			<input type="submit" name="Buscar" value="Buscar">
		</form>
	</div>
 	<div class="column">
 	<?php if($puedeMostrar != "false"): ?>
 		<h3 align="center"><?php echo $name; ?></h3>
		<div id="chartContainer" style="height: 250px; width: 100%;"></div>
		<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

		<h3 align="center">Media: <?php echo $media; ?></h3>
		<h3 align="center">Mediana: <?php echo $mediana; ?></h3>
		<h3 align="center">Moda: <?php echo $moda; ?></h3>
		<h3 align="center"><?php echo $puedeMostrar; ?></h3>
	<?php endif;
	if($puedeMostrar == "false"):
	?>
	<h2><?php echo $error; ?></h1>
	<?php
	endif;
	$conexion->close();?>
	</div>
</div>
</body>
</html>  