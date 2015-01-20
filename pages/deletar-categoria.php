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
<div class="title_box borderradius5">Deletar Categoria</div><!--/title_box-->
<span class="text_del">Você realmente deseja <strong>excluir</strong> essa categoria?</span>


<?php
$id = $_GET['id'];
?>

<form name="Form_del_user" action="" method="post">

    <?php
    if (isset($_POST['sim']) && $_POST['sim'] == 'Sim') {

        $verificaPosts = read('posts', "WHERE id_cat='$id'");

        if (count($verificaPosts) == 0) {
            $deletarCategoria = delete('categorias', "id='$id'");
            if (!$deletarCategoria) {
                echo '<div class="msg ok borderradius5" style="width:280px;margin:20px auto;">Categoria deletada. Atualizando página...</div>';
                echo '<script type="text/javascript">setTimeout(function(){location = "' . SITE . '/painel.php?pagina=categorias";}, 2000)</script>';
            } else {
                echo '<div class="msg error borderradius5" style="width:280px;margin:20px auto;">Error! Entre em contato com o suporte!</div>';
            }
        } else {

            foreach ($verificaPosts as $post):

                $posIdCat['id_cat'] = mysql_real_escape_string(strip_tags(trim('11')));

                $atualizaCategoriaPost = update('posts', $posIdCat, "id=$post[id]");
                if ($atualizaCategoriaPost) {
                    $deletarCategoria = delete('categorias', "id='$id'");
                    if (!$deletarCategoria) {
                        echo '<div class="msg ok borderradius5" style="width:280px;margin:20px auto;">Categoria deletada. Atualizando página...</div>';
                        echo '<script type="text/javascript">setTimeout(function(){location = "' . SITE . '/painel.php?pagina=categorias";}, 2000)</script>';
                    } else {
                        echo '<div class="msg error borderradius5" style="width:280px;margin:20px auto;">Error! Entre em contato com o suporte!</div>';
                    }
                } else {
                    echo '<div class="msg error borderradius5" style="width:280px;margin:20px auto;">Error! Entre em contato com o suporte!</div>';
                }

            endforeach;
        }
    }
    ?>
    <input type="submit" class="form_input_send send_del borderradius5" name="sim" value="Sim">
    <br>
    <a href="?pagina=usuarios" class="no_del borderradius5">Não</a>
</form>