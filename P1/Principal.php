<html>
<head>
    <meta charset=utf-8>
    <style>
	input[type="submit"] {
    width: 100px;
    height: 100px;}
	</style>
    <title>Encuesta ESI</title>
</head>
<body>
    <?php /* DEFINICIÓN DE FUNCIONES */
    // Devuelve la conexión con la base de datos que se pase
	function conectarBD($direccion = 'localhost', $usuario = 'root', 
            $contra = '', $nombreBD = 'p1', $puerto = '3309') {
        return new mysqli($direccion, $usuario, $contra, $nombreBD, $puerto);
    }

    // Devuelve una conexión según el servidor que se use, con datos predefinidos
    function conexionSegunServidor($tipoServer = 'WAMP') {
        if ($tipoServer == 'MAMP')
            return conectarBD('localhost', 'root', 'root', 'p1', '8889');
        return conectarBD();
    }
    /*-------------------------*/?>


    <!-- PÁGINA PRINCIPAL -->
    <!-- Selección del rol -->
    <h1>Bienvenido a la página de encuestas de la ESI</h1>
    Selecciona si eres un estudiante, para rellenar encuestas, o un profesor:<br>
    <form action = "<?php $_PHP_SELF ?>" method = 'post'>
        Rol:
            <input type = 'submit' name = 'rol' value = 'Estudiante'>
            <input type = 'submit' name = 'rol' value = 'Profesor'>
            <input type = 'submit' name = 'rol' value = 'Administrador'>
    </form>

    <?php
    // Comprobamos el rol del usuario
    if(isset($_POST['rol'])) {
        if($_POST['rol'] == 'Estudiante') {
            // Si es un alumno, vamos a Encuesta.php para que la rellene
            echo "Pula en Acceder para entrar a la encuesta:\n";
            echo "<form action = 'Encuesta.php' method = 'post'>\n";
            echo "<input type = 'submit' name = 'Acceder' value = 'Acceder'>\n";
            echo "</form>";
        }
        else if($_POST['rol'] == 'Profesor') {
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
        else {
            echo "Inicio de sesión para administradores. Se podrá insertar preguntas nuevas y se podrá consultar el estado de las tablas.\n<br>";
            echo "Por favor, introduce tu código y tu contraseña:\n";
            echo "<form action ="."'".$_PHP_SELF."'"."method = 'post'>\n";
            echo "Código: <input type = 'text' name = 'cod_admin' size = 4 maxlenght = 4>\n";
            echo "<br>Contraseña: <input type = 'password' name = 'contra_admin' size = 4 maxlenght = 4>\n";
            echo "<br><input type = 'submit' value = 'Iniciar sesión'>\n";
            echo "</form>";
        }
    }
    ?>

    <!-- INICIOS DE SESIÓN -->
    <?php
    // Conectamos a la base de datos
    $conexion = conexionSegunServidor('MAMP');

    if(isset($_POST['codigo'])) {
		$resultado = $conexion->query("Select * from Profesor 
			where Profesor.cod_prof like "."'".$codigo."'");
		$val = $resultado->num_rows;
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

    if(isset($_POST['cod_admin']) && isset($_POST['contra_admin'])) {
        $codigo = $_POST['cod_admin'];
        $clave = $_POST['contra_admin'];
        $resultado = $conexion->query("select * from Administrador
            where cod_admin like "."'".$codigo."'".
            "and contra_admin like "."'".$clave."'");
        $val = $resultado->num_rows;
        if($val == 0): ?>
			El código o la contraseña son incorrectos.
			<form action = 'Principal.php' method = 'post'>
				<input type = 'submit' value = 'Volver'>
			</form>
		<?php endif;
		if($val != 0): ?>
			¡El código y la contraseña son correctos!
			<form action = 'Resultados.php' method = 'post'>
				<input type = 'submit' value = 'Acceder'>
			</form>
		<?php endif; 
    }

    // Cerramos la conexión a la base de datos
    $conexion->close();
    ?>
</body>
</html>