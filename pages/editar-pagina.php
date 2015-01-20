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
<div class="title_box borderradius5">Editar Página</div><!--/title_box-->

<form name="form_informacoes" action="" method="post">   
    <?php
    $editId = $_GET['editId'];

    $buscaPagina = read('paginas', "WHERE id='$editId'");
    foreach ($buscaPagina as $pagina)
        ;


    if (isset($_POST['send']) && $_POST['send'] == 'Editar') {

        $editarPagina['titulo'] = mysql_real_escape_string(strip_tags(trim($_POST['titulo'])));
        $editarPagina['tags'] = mysql_real_escape_string(strip_tags(trim($_POST['tags'])));
        $editarPagina['content'] = mysql_real_escape_string($_POST['content']);
        $editarPagina['url'] = setUri($editarPagina['titulo']);
        $editarPagina['data_modificacao'] = date('Y-m-d H:1:s');

        if (in_array('', $editarPagina)) {
            echo '<div class="msg info borderradius5">Ooosp! Acho que esqueceu de preencher, existem campos em branco!</div>';
        } else {

            if ($editarPagina['url'] == $pagina['url']) {
                $editarPaginaBanco = update('paginas', $editarPagina, "id='$editId'");
                if (!$editarPaginaBanco) {
                    echo '<div class="msg error borderradius5">Error! Entre em contato com o suporte!</div>';
                } else {
                    echo '<div class="msg ok borderradius5">Página atualizada. Atualizando página...</div>';
                    echo '<script type="text/javascript">setTimeout(function(){location = "' . SITE . '/painel.php?pagina=paginas";}, 2000)</script>';
                }
            } else {

                $verificaTitulo = read('paginas', "WHERE url='$editarPagina[url]'");

                if ($verificaTitulo) {
                    echo '<div class="msg error borderradius5">Já existe uma página com esse título, por favor tente novamente.</div>';
                } else {

                    $editarPaginaBanco = update('paginas', $editarPagina, "id='$editId'");
                    if (!$editarPaginaBanco) {
                        echo '<div class="msg error borderradius5">Error! Entre em contato com o suporte!</div>';
                    } else {
                        echo '<div class="msg ok borderradius5">Página cadastrada. Atualizando página...</div>';
                        echo '<script type="text/javascript">setTimeout(function(){location = "' . SITE . '/painel.php?pagina=paginas";}, 2000)</script>';
                    }
                }
            }
        }
    }
    ?>

    <label>
        <span class="span_titulo">Título</span>
        <input class="form_input borderradius5" name="titulo" value="<?= $pagina['titulo']; ?>">
    </label>
    <label>
        <span class="span_titulo">Conteúdo</span>        
        <textarea id="tiny" class="form_textareaContent borderradius5" name="content"><?= $pagina['content'] ?></textarea>
    </label>

    <div class="title_box borderradius5">SEO</div><!--/title_box-->
    <label>
        <span class="span_titulo">Palavras chaves <font style="font-size: 11px; margin-left: 10px; color: green;">Ex.: internet, web, sites, websites</font></span>
        <input class="form_input borderradius5" name="tags" value="<?= $pagina['tags']; ?>">
    </label>

    <input class="form_input_send borderradius5 send_categoria" type="submit" value="Editar" name="send">
</form>