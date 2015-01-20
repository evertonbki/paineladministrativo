<?php
if (!empty($_SESSION['usuarioAutenticado'])) {
    $loginAutenticado = $_SESSION['usuarioAutenticado']['login'];
    $senhaAutenticada = $_SESSION['usuarioAutenticado']['senha'];

    $VereficaSessaoAutenticada = read('usuarios', "WHERE login='$loginAutenticado' AND senha='$senhaAutenticada'");
    foreach($VereficaSessaoAutenticada as $usuarioAutenticado);
  
}else{
    echo '<script type="text/javascript">setTimeout(function(){location = "..//logout.php";}, 2000)</script>';
        header('location: ../logout.php');
        die();    
}
?>
<div class="title_box borderradius5">Deletar Usuário</div><!--/title_box-->
<span class="text_del">Você realmente deseja <strong>excluir</strong> esse usuário?</span>
<form name="Form_del_user">
        <input type="submit" class="form_input_send send_del borderradius5" name="sim" value="Sim">
        <br>
        <a href="#" class="no_del borderradius5">Não</a>
</form>