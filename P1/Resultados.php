<!DOCTYPE html>
<html>
<head>
	<title>Resultados</title>
</head>
<body>
	<?php
		$dbhost = '127.0.0.1';
		$dbuser = 'root';
		$dbpass = '';
		$db = 'p1';
		$port = '3308';
		$conexion = mysqli_connect($dbhost,$dbuser,$dbpass,$db,$port) or die ("No se pudo establecer conexion con el servidor");
		
		$id_asig = 0;
		mysqli_query($conexion,"INSERT INTO encuesta (id_en,id_doc,edad,sexo,curso_sup,curso_inf,n_matri,n_exam,interes,tutorias,dificultad,calif,asist) VALUES (NULL,'".$id_asig."','".$_POST['edad']."','".$_POST['sexo']."','".$_POST['calto']."','".$_POST['cbajo']."','".$_POST['vmat']."','".$_POST['vexaminado']."','".$_POST['interes']."','".$_POST['tutoria']."','".$_POST['dificultad']."','".$_POST['calificacion']."','".$_POST['asistencia']."')") or die("F");

		$res = mysqli_query($conexion,"SELECT * FROM inf_per ORDER BY id_ip DESC LIMIT 1") or die ("Fallo consulta tabla");
		$row = mysqli_fetch_assoc($res);
		for($j = 1;$j <= 3;$j++){
			$cod_prof = $_POST['pro'.$j.'cod1'].$_POST['pro'.$j.'cod2'].$_POST['pro'.$j.'cod3'].$_POST['pro'.$j.'cod4'];
			echo $cod_prof."<br>";
			mysqli_query($conexion,"INSERT INTO preg_resp (id_ip,cod_prof,resp_1,resp_2,resp_3) VALUES (".$row['id_ip'].",".$cod_prof.",".$_POST['pro1pre1'].",".$_POST['pro1pre2'].",".$_POST['pro1pre3'].")");
		}
		mysqli_close($conexion);
	?>
</body>
</html>