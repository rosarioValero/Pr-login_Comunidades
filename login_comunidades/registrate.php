<?php  //session_start();
require_once __DIR__ .'/class/database.php';
if (isset($_SESSION['email'])) {
    # code...
    header('Location: index.php');
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # code...
    $usuario = filter_var(strtolower($_POST['usuario']), FILTER_SANITIZE_STRING);
    $password = $_POST['password'];
	$password2 = $_POST['password2'];
	$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $nombre = filter_var($_POST['nombre'],FILTER_SANITIZE_STRING);
    $errores = '';

    if (empty($usuario) or empty($email) or empty($nombre) or empty($password) or empty($password2)) {
        # code...
        $errores .= '<li>Por favor rellena todos los campos.</li>';
    }else{
        $conexion = database::makecon();
        $statement = $conexion->prepare('SELECT * FROM usuario_prueba WHERE usuario = :usuario LIMIT 1');
		$statement->execute(array(':usuario' => $usuario));
		$resultado = $statement->fetch();

		if ($resultado != false) {
			$errores .= '<li>El nombre de usuario ya existe</li>';
		}

		$password = hash('sha512', $password);
		$password2 = hash('sha512', $password2);

		if ($password != $password2) {
			$errores .= '<li>Las contraseñas no son iguales</li>';
		}
	}

	if ($errores == '') {
		$statement = $conexion->prepare('INSERT INTO usuario_prueba (usuario,email,nombre,contraseña, active) VALUES (:usuario,:email,:nombre, :pass , false)');
		$statement->execute(array(
			':usuario' => $usuario,
			':email' => $email,
			':nombre' => $nombre,
			':pass' => $password
		));

		header('Location: login.php');
	}


}
require 'views/registrate.view.php';


?>