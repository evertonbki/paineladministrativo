<?php
if (!empty($_SESSION['usuarioAutenticado'])) {
    $loginAutenticado = $_SESSION['usuarioAutenticado']['login'];
    $senhaAutenticada = $_SESSION['usuarioAutenticado']['senha'];

    $VereficaSessaoAutenticada = read('usuarios', "WHERE login='$loginAutenticado' AND senha='$senhaAutenticada'");
    foreach($VereficaSessaoAutenticada as $usuarioAutenticado);
  
}else{
    echo '<script type="text/javascript">setTimeout(function(){location = "../' . SITE . '/logout.php";}, 2000)</script>';
        header('location: ../' . SITE . '/logout.php');
        die();    
}
?>