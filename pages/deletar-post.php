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
<span class="text_del">Você realmente deseja <strong>excluir</strong> esse post?</span>


<?php
$id = $_GET['id'];
?>

<form name="Form_del_user" action="" method="post">

    <?php
    if (isset($_POST['sim']) && $_POST['sim'] == 'Sim') {
        $verificarIlustracao = read('posts', "WHERE id=$id");
        foreach ($verificarIlustracao as $post);

        if (empty($post['ilustracao'])) {
            $deletarPost = delete('posts', "id='$id'");
            if (!$deletarPost) {
                echo '<div class="msg ok borderradius5" style="width:280px;margin:20px auto;">Post deletado. Atualizando página...</div>';
                echo '<script type="text/javascript">setTimeout(function(){location = "' . SITE . '/painel.php?pagina=posts";}, 2000)</script>';
            } else {
                echo '<div class="msg error borderradius5" style="width:280px;margin:20px auto;">Error! Entre em contato com o suporte!</div>';
            }
        } else {
            
            $pasta = ('uploads/capas/');
            $arquivo = $post['ilustracao'];            
            $ilustracao = $pasta.$arquivo;

            $delImagem = unlink($ilustracao);
            if(!$delImagem){
                echo '<div class="msg error borderradius5" style="width:280px;margin:20px auto;">Error! Entre em contato com o suporte!</div>';
            }else{
                $deletarPostImagem = delete('posts', "id='$id'");
            if (!$deletarPostImagem) {
                echo '<div class="msg ok borderradius5" style="width:280px;margin:20px auto;">Post deletado. Atualizando página...</div>';
                echo '<script type="text/javascript">setTimeout(function(){location = "' . SITE . '/painel.php?pagina=posts";}, 2000)</script>';
            } else {
                echo '<div class="msg error borderradius5" style="width:280px;margin:20px auto;">Error! Entre em contato com o suporte!</div>';
            }
            }                        
        }

    }
    ?>
    <input type="submit" class="form_input_send send_del borderradius5" name="sim" value="Sim">
    <br>
    <a href="?pagina=usuarios" class="no_del borderradius5">Não</a>
</form>