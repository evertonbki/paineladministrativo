<?php  
	session_start();
	unset($_SESSION['usuarioAutenticado']);
	session_destroy();
        
        echo '<script type="text/javascript">setTimeout(function(){location = "' . SITE . '/login.php";}, 2000)</script>';
        header('location: login.php');
        die();
?> 
