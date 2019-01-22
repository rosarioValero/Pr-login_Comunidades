<?php 
require_once __DIR__ .'/class/database.php';
session_start();
if (isset($_SESSION['email'])) {
	header('Location: index.php');
}

$errores = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
	$password = $_POST['password'];
	$password = hash('sha512', $password);

	$conexion = Database::makecon();

	$statement = $conexion->prepare('
		SELECT * FROM usuario_prueba WHERE email = :email AND contraseña = :password'
	);
	$statement->execute(array(
		':email' => $email,
		':password' => $password
	));

	$resultado = $statement->fetch();
	if ($resultado !== false) {
		//session_start($email);
		$_SESSION['email'] = $email;
		header('Location: index.php');
	} else {
		$errores .= '<li>Datos Incorrectos</li>';
	}
}

require 'views/login.view.php';

?>