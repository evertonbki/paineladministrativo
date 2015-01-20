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
<div class="title_box borderradius5">Buscar Páginas</div><!--/title_box-->

<form method="post" name="form_search_paginas">
    <label>
        <input type="text" class="borderradius5" name="search-page" value="Palavra chave" onfocus="this.value=''" onblur="if(this.value==''){this.value='Palavra chave'}">
    </label>
    <input type="submit" name="send_search_paginas" class="send_searchPg" value="">
</form>
