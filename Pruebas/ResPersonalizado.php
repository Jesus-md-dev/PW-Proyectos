<?php
	error_reporting(E_ERROR | E_PARSE);
	$dbhost = '127.0.0.1';
	$dbuser = 'root';
	$dbpass = '';
	$db = 'p1';
	$port = '3308';
	$conexion = new mysqli($dbhost,$dbuser,$dbpass,$db,$port) or die ("No se pudo establecer conexion con el servidor");
	$puedeMostrar = "false";
	//Valores
	$typeChart = $_POST['typeChart'];

	$vector['chart'] = array("1" => "column", "2" => "bar", "3" => "pie", "4" => "doughnut");
	$vector['grafica'] = array("1" => "Columnas", "2" => "Barras", "3" => "Circular", "4" => "Donut");

	$chart = $vector['chart'][$typeChart];

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

	$cEdad = $_POST['cEdad'];
	$edad = $_POST['edad'];
	$vector['edad'] = array("1" => "<=19", "2" => "20-21", "3" => "21-23", "4" => "
		24-25", "5" => ">25");
	$nTipo['edad'] = "edad";

	$cSexo = $_POST['cSexo'];
	$sexo = $_POST['sexo'];
	$vector['sexo'] = array("1" => "Hombre", "2" => "Mujer");
	$nTipo['sexo'] = "sexo";

	$cAlto = $_POST['cAlto'];
	$alto = $_POST['alto'];
	$vector['alto'] = array("1" => "1º", "2" => "2º", "3" => "3º", "4" => "4º", "5" => "5º", "6" => "6º");
	$nTipo['alto'] = "curso_sup";

	$cBajo = $_POST['cBajo'];
	$bajo = $_POST['bajo'];
	$vector['bajo'] = array("1" => "1º", "2" => "2º", "3" => "3º", "4" => "4º", "5" => "5º", "6" => "6º");
	$nTipo['bajo'] = "curso_inf";

	$cMatriculado = $_POST['cMatriculado'];
	$matriculado = $_POST['matriculado'];
	$vector['matriculado'] = array("1" => "1", "2" => "2", "3" => "3", "4" => ">3");
	$nTipo['matriculado'] = "n_matri";

	$cExaminado = $_POST['cExaminado'];
	$examinado = $_POST['examinado'];
	$vector['examinado'] = array("1" => "1", "2" => "2", "3" => "3", "4" => ">3");
	$nTipo['examinado'] = "n_exam";

	$cInteres = $_POST['cInteres'];
	$interes = $_POST['interes'];
	$vector['interes'] = array("1" => "Nada", "2" => "Algo", "3" => "Bastante", "4" => "Mucho");
	$nTipo['interes'] = "interes";

	$cTutorias = $_POST['cTutorias'];
	$tutorias = $_POST['tutorias'];
	$vector['tutorias'] = array("1" => "Nada", "2" => "Algo", "3" => "Bastante", "4" => "Mucho");
	$nTipo['tutorias'] = "tutorias";

	$cDificultad = $_POST['cDificultad'];
	$dificultad = $_POST['dificultad'];
	$vector['dificultad'] = array("1" => "Baja", "2" => "Media", "3" => "Alta", "4" => "Muy alta");
	$nTipo['dificultad'] = "dificultad";

	$cCalificacion = $_POST['cCalificacion'];
	$calificacion = $_POST['calificacion'];
	$vector['calificacion'] = array("1" => "No Presentado", "2" => "Suspenso", "3" => "Aprobado", "4" => "Notable", "5" => "Sobresaliente", "6" => "Matricula de Honor");
	$nTipo['calificacion'] = "calif";

	$cAsistencia = $_POST['cAsistencia'];
	$asistencia = $_POST['asistencia'];
	$vector['asistencia'] = array("1" => "Menos 50%", "2" => "Entre 50% y 80%", "3" => "Más de 80%");
	$nTipo['asistencia'] = "asist";

	$vector['pregunta'] = array("1"=> "N.S.", "2" => "1", "3" => "2", "4" => "3", "5" => "
		4", "6" => "5");

	$QDocencia = "false";
	$QEncuesta = "false";

	$valorNulo = "0";
	$unAtributo = "global";

	$atributo = $_POST[$unAtributo];

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

function selectContent($title,$name,$vector)
{
	echo "<input type=radio name=$GLOBALS[unAtributo] value=$name>";
	echo " ".$title.": ";
	echo "<select name=$name>";
		echo "<option value=0></option>";
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
	$puedeMostrar = "true";

	if($pregunta == "-1")
		$nombrePregunta = "Todas";
	else
	{
		$query = $conexion->query("Select * from pregunta where cod_preg = ".$pregunta) or die("Fallo consulta Pregunta");
		$result = $query->fetch_assoc();
		$nombrePregunta = $result['enunciado'];
	}

	$name = "Pregunta: ".$nombrePregunta;

	if($profesor != $valorNulo):
		$resp = $conexion->query("select * from profesor where cod_prof = $profesor") or die ("Fallo Profesor");
		$fila = $resp->fetch_assoc();
		$name = $name." | Profesor: ".$fila['nombre'];
	endif;

	if($titulacion != $valorNulo):
		$resp = $conexion->query("select * from titulacion where cod_tit = $titulacion") or die ("Fallo titulacion");
		$fila = $resp->fetch_assoc();
		$name = $name." | Titulación: ".$fila['nombre'];
	endif;

	if($asignatura != $valorNulo):
		$resp = $conexion->query("select * from asignatura where cod_asig = $asignatura") or die ("Fallo asignatura");
		$fila = $resp->fetch_assoc();
		$name = $name." | Asignatura: ".$fila['nombre'];
	endif;

	if($grupo != $valorNulo):
		$resp = $conexion->query("select * from grupo where cod_grup = $grupo") or die ("Fallo Grupo");
		$fila = $resp->fetch_assoc();
		$name = $name." | Grupo: ".$fila['cod_grup'];
	endif;

	//*Docencia

	$select = "id_doc";$tabla = "docencia";$where = " where(";$wherecond = "false";
	$docQuery = "select ".$select." from ".$tabla;

	if($titulacion != $valorNulo || $asignatura != $valorNulo || $grupo != $valorNulo)
	{
		$QDocencia = "true";
		if($titulacion != $valorNulo)
			insertarWhere($wherecond,$where,$titulacion,"cod_tit");
		if($asignatura != $valorNulo)
			insertarWhere($wherecond,$where,$asignatura,"cod_asig");
		if($grupo != $valorNulo)
			insertarWhere($wherecond,$where,$grupo,"cod_grup");
		if($wherecond == "true")
			$docQuery = $docQuery.$where.")";
		
		if($profesor != $valorNulo)
		{
			$q = "select * from profesordocencia where (cod_prof = $profesor and id_doc in ($docQuery))";
			$res = $conexion->query($q);
			if($res->num_rows <= 0):
				$puedeMostrar = "false";
				$error = "El Profesor $profesor no pertenece a: <br>";
				if($titulacion != $valorNulo):
					$query = $conexion->query("Select * from titulacion where (cod_tit = $titulacion)") or die("Fallo consulta");
					$row = $query->fetch_assoc();
					$error = $error."<br>-Titulación: $row[nombre] ";
				endif;
				if($asignatura != $valorNulo):
					$query = $conexion->query("Select * from asignatura where (cod_asig = $asignatura)") or die("Fallo consulta");
					$row = $query->fetch_assoc();
					$error = $error."<br>-Asignatura: $row[nombre] ";
				endif;
				if($grupo != $valorNulo)
					$error = $error."<br>-Grupo: $grupo ";
			endif;			
		}
	}

	//Docencia

	//*Encuesta
	if(!isset($atributo))
		$select = "id_en";
	else
		$select = $nTipo[$atributo];
	$tabla = "Encuesta";$where = " where(";$wherecond = "false";
	$id_enQuery = "select ".$select." from ".$tabla;

	if($edad!=$valorNulo || $sexo!=$valorNulo || $alto != $valorNulo || $bajo != $valorNulo || $matriculado != $valorNulo || $examinado != $valorNulo  || $interes != $valorNulo || $tutorias != $valorNulo || $dificultad != $valorNulo || $calificacion != $valorNulo || $asistencia != $valorNulo || $QDocencia == "true")
	{
		$QEncuesta = "true";
		if($edad!=$valorNulo)
			insertarWhereName($wherecond,$where,$vector['edad'],$edad,"edad","Edad",$name);

		if($sexo!=$valorNulo)
			insertarWhereName($wherecond,$where,$vector['sexo'],$sexo,"sexo","Sexo",$name);

		if($alto!=$valorNulo)
			insertarWhereName($wherecond,$where,$vector['alto'],$alto,"curso_sup","Curso más alto",$name);

		if($bajo!=$valorNulo)
			insertarWhereName($wherecond,$where,$vector['bajo'],$bajo,"curso_inf","Curso más bajo",$name);

		if($matriculado!=$valorNulo)
			insertarWhereName($wherecond,$where,$vector['matriculado'],$matriculado,"n_matri","Veces matriculado",$name);

		if($examinado!=$valorNulo)
			insertarWhereName($wherecond,$where,$vector['examinado'],$examinado,"n_exam","Veces examinado",$name);

		if($interes!=$valorNulo)
			insertarWhereName($wherecond,$where,$vector['interes'],$interes,"interes","Interés",$name);

		if($tutorias!=$valorNulo)
			insertarWhereName($wherecond,$where,$vector['tutorias'],$tutorias,"tutorias","Tutorías",$name);

		if($dificultad!=$valorNulo)
			insertarWhereName($wherecond,$where,$vector['dificultad'],$dificultad,"dificultad","Dificultad",$name);

		if($calificacion!=$valorNulo)
			insertarWhereName($wherecond,$where,$vector['calificacion'],$calificacion,"calif","Calificacion",$name);

		if($asistencia!=$valorNulo)
			insertarWhereName($wherecond,$where,$vector['asistencia'],$asistencia,"asist","Asistencia",$name);

		if($QDocencia == "true"):
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

	//*Respuesta

	if(!isset($atributo))
	{
		$select = "*";$tabla = "respuesta";$where = " where(";$wherecond = "false";

		$Query = "select ".$select." from ".$tabla;

		if($pregunta != "-1")
			insertarWhere($wherecond,$where,$pregunta,"cod_preg",);

		if($profesor != $valorNulo)
			insertarWhere($wherecond,$where,$profesor,"cod_prof",);

		if($QEncuesta == "true"):
			if($wherecond == "true")
				$where = $where." and ";
			else
				$wherecond = "true";
			$where = $where."id_en in (".$id_enQuery.")";
		endif;

		if($wherecond == "true")
			$Query = $Query.$where.")";
		echo $Query;
		$respuestas = $conexion->query("$Query") ;//or die("Fallo respuestas");
		$nindice = "resp";
	}
	else
	{
		$respuestas = $conexion->query("$id_enQuery");
		$nindice = $nTipo[$atributo];
	}

	$nrespuestas = $respuestas->num_rows;

	//Respuesta

	$i=1;
	if(isset($atributo))
	{
		foreach ($vector[$atributo] as $v) 
		{
			$vectorLabel[$i] = $v;
			$i++;
		}
	}
	else
	{
		foreach ($vector['pregunta'] as $v) 
		{
			$vectorLabel[$i] = $v;
			$i++;
		}
	}
	
	$nopciones = count($vectorLabel);

	for($i = 1; $i <= $nopciones; $i++)
	{
		$valorOpcion[$i] = 0;
	}

	while($respFila = $respuestas->fetch_assoc()):
		$vectorRespuestas[] = $respFila[$nindice];
		$valorOpcion[$respFila[$nindice]]++;
	endwhile;

	$dataPoints = array();

	for($i = 1; $i <= $nopciones; $i++)
	{
		$array = array("y"=> $valorOpcion[$i], "label"=> $vectorLabel[$i]);
		array_push($dataPoints,$array);
	}
	echo "<br>";
	print_r($dataPoints);
endif;

	//echo "Docencia: ".$docQuery."<br>";
	//echo "Encuesta: ".$id_enQuery."<br>";
	//echo "Respuesta: ".$Query."<br>";
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
				type: "<?php echo "$chart" ?>",
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
	</style>
</head>

<body>
<div>
	<h1 align = center>Resultados de las Encuestas</h1>
	<div class="column">
		
		<form action="ResPersonalizado.php" method="post">
			<h2>Opciones:</h2>
			Tipo de gráfico: 
			<select name=typeChart>;
			 <?php for($i=1; $i <= count($vector['grafica']); $i++) {
				echo "<option value=".$i.">".$vector['grafica'][$i]."</option>";  
			} ?>
			</select>
			<br>

			<h3>Filtros:</h3>
			<!--<input type="checkbox" name="cPregunta" value="true">-->
			&#10033;Pregunta: <select name=pregunta>
			<option value="-1">Todas</option>
			<?php 
			$query = $conexion->query("Select * from pregunta") or die("Fallo consulta");
			echo "<option value=0></option>";
			while ($row = $query->fetch_assoc()):
				echo "<option value=".$row['cod_preg'].">".$row['enunciado']."</option>";
			endwhile;
			?>
			</select>
			<br>

			<!--<input type="checkbox" name="cProfesor" value="true">-->
			&#10033;Profesor: <select name=profesor>
			<?php 
			$query = $conexion->query("Select * from profesor") or die("Fallo consulta");
			echo "<option value=0></option>";
			while ($row = $query->fetch_assoc()):
				echo "<option value=".$row['cod_prof'].">".$row['nombre']."</option>";
			endwhile; 
			?>
			</select>
			<br>

			<!--<input type="checkbox" name="cTitulacion" value="true">-->
			&#10033;Titulación: <select name=titulacion>
			<?php 
			$query = $conexion->query("Select * from titulacion") or die("Fallo consulta");
			echo "<option value=0></option>";
			while ($row = $query->fetch_assoc()):
				echo "<option value=".$row['cod_tit'].">".$row['nombre']."</option>";
			endwhile; 
			?>
			</select>
			<br>

			<!--<input type="checkbox" name="cAsignatura" value="true">-->
			&#10033;Asignatura: <select name=asignatura>
			<?php 
			$query = $conexion->query("Select * from asignatura") or die("Fallo consulta");
			echo "<option value=0></option>";
			while ($row = $query->fetch_assoc()):
				echo "<option value=".$row['cod_asig'].">".$row['nombre']."</option>";
			endwhile; 
			?>
			</select>
			<br>

			<!--<input type="checkbox" name="cGrupo" value="true">-->
			&#10033;Grupo: <select name=grupo>
			<?php 
			$query = $conexion->query("Select * from grupo") or die("Fallo consulta");
			echo "<option value=0></option>";
			while ($row = $query->fetch_assoc()):
				echo "<option value=".$row['cod_grup'].">".$row['cod_grup']."</option>";
			endwhile; 
			?>
			</select>
			<br>

			<?php 

			selectContent("Edad","edad",$vector['edad']);
			selectContent("Sexo","sexo",$vector['sexo']);
			selectContent("Curso más alto","alto",$vector['alto']);
			selectContent("Curso más bajo","bajo",$vector['bajo']);
			selectContent("Veces matriculado","matriculado",$vector['matriculado']);
			selectContent("Veces examinado","examinado",$vector['examinado']);
			selectContent("Interés","interes",$vector['interes']);
			selectContent("Uso de tutorías","tutorias",$vector['tutorias']);
			selectContent("Dificultad","dificultad",$vector['dificultad']);
			selectContent("Calificación esperada","calificacion",$vector['calificacion']);
			selectContent("Asistencia","asistencia",$vector['asistencia']);

			?>

			<input type="submit" name="Buscar" value="Buscar">
			<br>
			<i>&nbsp;&nbsp;*Marcar una opción para mostrar la gráfica de ese atributo.</i>
		</form>
	</div>
 	<div class="column">

 	<?php if($puedeMostrar == "true"): ?>
 		<h3 align="center"><?php echo $name; ?></h3>
		<div id="chartContainer" style="height: 250px; width: 100%;"></div>
		<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
		<?php if(!isset($atributo)): ?>
		<h3 align="center">Media: <?php echo $media; ?></h3>
		<h3 align="center">Mediana: <?php echo $mediana; ?></h3>
		<h3 align="center">Moda: <?php echo $moda; ?></h3>
		<?php endif; ?>
	<?php endif;
	if($puedeMostrar == "false"):
	?>
	<h2><?php echo $error; ?></h2>
	<?php
	endif;

	$conexion->close();?>
	</div>
</div>
</body>
</html>  