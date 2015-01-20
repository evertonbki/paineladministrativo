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
<div class="title_box borderradius5">Editar Categoria</div><!--/title_box-->

<form name="form_informacoes" action="" method="post">
    <?php
    $editId = $_GET['editId'];

    $buscaCategoria = read('categorias', "WHERE id ='$editId'");
    foreach ($buscaCategoria as $categoria)
        ;

    if (isset($_POST['send']) && $_POST['send'] == 'Editar') {

        $editaCategoria['nome'] = mysql_real_escape_string(strip_tags(trim($_POST['titulo'])));
        $editaCategoria['descricao'] = mysql_real_escape_string(strip_tags(trim($_POST['descricao'])));
        $editaCategoria['data_modicacao'] = date('Y-m-d h.i.s');
        $editaCategoria['url'] = setUri($editaCategoria['nome']);

        if (in_array('', $editaCategoria)) {
            echo '<div class="msg info borderradius5">Ooops! Existem campos em branco!</div>';
        } else {
            if ($categoria['url'] == $editaCategoria['url']) {
                $atualizaCategoria = update('categorias', $editaCategoria, "id='$editId'");
                if ($atualizaCategoria) {
                    echo '<div class="msg ok borderradius5">Categoria atualizada. Atualizando página...</div>';
                    echo '<script type="text/javascript">setTimeout(function(){location = "' . SITE . '/painel.php?pagina=categorias";}, 2000)</script>';
                } else {
                    echo '<div class="msg error borderradius5">Error! Entre em contato com o suporte!</div>';
                }
            } else {
                $verificaCategoria = read('categorias', "WHERE url='$editaCategoria[url]'");
                if ($verificaCategoria) {
                    echo '<div class="msg error borderradius5">Título já existe, por favor utilize outro!</div>';
                } else {
                    $atualizaCategoriaNova = update('categorias', $editaCategoria, "id='$editId'");
                    if ($atualizaCategoriaNova) {
                        echo '<div class="msg ok borderradius5">Categoria atualizada. Atualizando página...</div>';
                        echo '<script type="text/javascript">setTimeout(function(){location = "' . SITE . '/painel.php?pagina=categorias";}, 2000)</script>';
                    } else {
                        echo '<div class="msg error borderradius5">Error! Entre em contato com o suporte!</div>';
                    }
                }
            }
        }
    }
    ?>
    <label>
        <span class="span_titulo">Título da categoria</span>
        <input class="form_input borderradius5" name="titulo" value="<?= $categoria['nome']; ?>">
    </label>
    <label>
        <span class="span_titulo">Descrição</span>        
        <textarea class="form_textarea borderradius5" name="descricao"><?= $categoria['descricao']; ?></textarea>
    </label>    
    <input class="form_input_send borderradius5 send_categoria" type="submit" value="Editar" name="send">
</form>