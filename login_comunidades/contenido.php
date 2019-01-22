<?php
session_start();
if (isset($_SESSION['email'])) {
	require 'views/contenido.view.php';
} else {
	header('Location: login.php');
}
?>