<?php
if (!empty($_SESSION['usuarioAutenticado'])) {
    $loginAutenticado = $_SESSION['usuarioAutenticado']['login'];
    $senhaAutenticada = $_SESSION['usuarioAutenticado']['senha'];

    $VereficaSessaoAutenticada = read('usuarios', "WHERE login='$loginAutenticado' AND senha='$senhaAutenticada'");
    foreach ($VereficaSessaoAutenticada as $usuarioAutenticado)
        ;
} else {
    echo '<script type="text/javascript">setTimeout(function(){location = "..//logout.php";}, 2000)</script>';
    header('location: ../logout.php');
    die();
}
?>
<div class="title_box borderradius5">Cadastrar Galeria de Página</div><!--/title_box-->
<form name="form_informacoes" action="" method="post" enctype="multipart/form-data">
    <?php
    $id = $_GET['id'];
    $BuscaPagina = read('paginas', "WHERE id ='$id'");
    foreach ($BuscaPagina as $pagina);

    if (isset($_POST['send']) && $_POST['send'] == 'Cadastrar') {
        
        $arq = $_FILES['arq'];
        $permissao = array('image/jpg', 'image/jpeg', 'image/png');
        $ext = ($arq['type'] == 'image/png' ? '.png' : '.jpg');
        $size = 1024 * 1024 * 2;
        $pasta = 'uploads/galerias';
        $nome = md5(time()) . $ext;

        for ($i = 0; $i < count($arq['tmp_name']); $i++) {

            $arqNome = md5($arq['tmp_name'][$i]) . $ext;

            if ($arq['size'][$i] > $size) {
                echo '<div class="msg error borderradius5"><span>error: </span>Arquivo : '.$arq['name'][$i].' não pode ser maior que 2Mb.</div>';
                die();
            } elseif (!in_array($arq['type'][$i], $permissao)) {
                echo '<div class="msg error borderradius5"><span>error: </span>Apenas <strong>JPG</strong> ou <strong>PNG</strong>.</div>';
                die();
            }

            if (move_uploaded_file($arq['tmp_name'][$i], $pasta . '/' . $arqNome)) {
                echo '<div class="msg ok borderradius5"><span>successo: </span> ' . $arq['name'][$i] . ' enviado.</div>';
                
                    $galeriaDados['id_pagina'] = $id;
                    $galeriaDados['imagem'] = $arqNome;
                    $galeriaDados['data_criacao'] = date('Y-m-d H:1:s');
                    
                    if(!create('galerias', $galeriaDados)){
                        echo '<div class="msg error borderradius5">Error! Entre em contato com o suporte!</div>';
                    }
                
            } else {
                echo '<div class="alert-box error"><span>error: </span>Arquivo não enviado.</div>';
            }
        }
        
    }
  
    ?>    
    <label>
        <span class="span_titulo">Selecione suas imagens</span>
        <input type="file" name="arq[]" multiple />

    </label>

    <input class="form_input_send borderradius5 send_post" type="submit" value="Cadastrar" name="send">
</form>