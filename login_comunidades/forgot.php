<?php 
require_once __DIR__ .'/class/database.php';
session_start();
if (isset($_SESSION['email'])) {
	header('Location: index.php');
}

$errores = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

	$conexion = database::makecon();

	$statement = $conexion->prepare('
		SELECT * FROM usuario_prueba WHERE email = :email'
	);
	$statement->execute(array(
		':email' => $email
	));

	$resultado = $statement->fetch();
	if ($resultado !== false) {
		
		header('Location: cambiarcontraseña.php');
	} else {
		$errores .= '<li>Datos Incorrectos</li>';
	}
}

require 'views/forgot.view.php';

?>