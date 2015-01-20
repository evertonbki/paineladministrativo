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
<div class="title_box borderradius5">Deletar Post</div><!--/title_box-->
<span class="text_del">Você realmente deseja <strong>excluir</strong> essa galeria?</span>


<?php
$id = $_GET['id'];
?>

<form name="Form_del_user" action="" method="post">

    <?php
    if (isset($_POST['sim']) && $_POST['sim'] == 'Sim') {
        $verificarGaleria = read('galerias', "WHERE id_pagina=$id");

        $pasta = ('uploads/galerias/');
        $arquivo = $galeria['imagem'];

        foreach ($verificarGaleria as $galeria):
            unlink($pasta . $galeria['imagem']);
        endforeach;

        if (!delete('galerias', "id_pagina=$id")) {
            echo '<div class="msg ok borderradius5" style="width:280px;margin:20px auto;">Galeria deletada. Atualizando página...</div>';
            echo '<script type="text/javascript">setTimeout(function(){location = "' . SITE . '/painel.php?pagina=galeria-pagina";}, 2000)</script>';
        } else {
            echo '<div class="msg error borderradius5">Error! Entre em contato com o suporte!</div>';
        }
    }
    ?>
    <input type="submit" class="form_input_send send_del borderradius5" name="sim" value="Sim">
    <br>
    <a href="?pagina=usuarios" class="no_del borderradius5">Não</a>
</form>