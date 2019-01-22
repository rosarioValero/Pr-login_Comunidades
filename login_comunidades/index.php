<?php  
session_start();

if (isset($_SESSION['email'])) {
    # code...
    header('Location: contenido.php');
}else {
    header('Location: registrate.php');
}

?>