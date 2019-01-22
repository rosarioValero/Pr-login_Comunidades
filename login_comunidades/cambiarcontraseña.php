<?php  //session_start();
require_once __DIR__ .'/class/database.php';
if (isset($_SESSION['email'])) {
    # code...
    header('Location: index.php');
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    # code...
    $password = $_POST['password'];
	$password2 = $_POST['password2'];
	$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $errores = '';

    if (empty($email) or empty($password) or empty($password2)) {
        # code...
        $errores .= '<li>Por favor rellena todos los campos.</li>';
    }else{
		
		$conexion = database::makecon();
        $statement = $conexion->prepare('SELECT * FROM usuario_prueba WHERE email = :email LIMIT 1');
		$statement->execute(array(':email' => $email));
		$resultado = $statement->fetch();

		if ($resultado != true) {
			$errores .= '<li>El email es incorrecto</li>';
		}
		$password = hash('sha512', $password);
		$password2 = hash('sha512', $password2);
		
		if ($password != $password2) {
			$errores .= '<li>Las contraseñas no son iguales</li>';
		}

	}

	if ($errores == '') {
		$statement = $conexion->prepare('UPDATE usuario_prueba SET contraseña = :pass WHERE email = :email');
		$statement->execute(array(
			':email' => $email,
			':pass' => $password
		));

		header('Location: login.php');
	}


}
require 'views/cambiarcontraseña.view.php';


?>