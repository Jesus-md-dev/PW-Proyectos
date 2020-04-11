<html>
<head>
    <meta charset=utf-8>
    <title>Encuesta ESI</title>
</head>
<body>
    <!-- Selección del rol -->
    <h1>Bienvenido a la página de encuestas de la ESI</h1>
    Selecciona si eres un estudiante, para rellenar encuestas, o un profesor:<br><br>
    <form action = "<?php $_PHP_SELF ?>" method = 'post'>
        Rol:
            <input type = 'submit' name = 'rol' value = 'Estudiante'>
            <input type = 'submit' name = 'rol' value = 'Profesor'>
    </form>

    <?php
    // Procesamos el rol del usuario
    if(isset($_POST['rol'])) {
        if($_POST['rol'] == 'Estudiante')
            // Si es un alumno, vamos a Encuesta.php para que la rellene
            header("Location: Encuesta.php");
        else {
            // Si es profe, se va a preguntar por su codigo:
            echo "Introduce el código de profesor asociado: "; 
            /* Formulario en html:
            <form action ='Resultados.php' method = 'post'>
                <input type = 'text' name = 'codigo' size = 4 maxlenght = 4>
                <input type= 'submit' value= 'Aceptar'>
            </form>
            Equivalente en PHP: */
            echo "<form action ="."'".$_PHP_SELF."'"."method = "."'"."post"."'".">".
                "<input type = "."'"."text"."'"." name = "."'"."codigo"."'"." size = 4 maxlenght = 4>".
                "<input type="."'"."submit"."'"." value="."'"."Aceptar"."'".">".
                "</form>";
        }
    }
    ?>

    <!-- Procesamos el código del profesor -->
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
		if($val == 0): ?>
			El código es incorrecto.
			<form action = 'Principal.php' method = 'post'>
				<input type = 'submit' value = 'Volver'>
			</form>
		<?php endif;
		if($val != 0): ?>
			¡El código es correcto!
			<form action = 'Resultados.php' method = 'post'>
				<input type = 'hidden' name = 'cod_prof' value = <?php echo $codigo ?> >
				<input type = 'submit' value = 'Acceder'>
			</form>
		<?php endif;
    }
    ?>
</body>
</html>