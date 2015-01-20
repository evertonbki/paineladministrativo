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
<div class="title_box borderradius5">Cadastrar Página</div><!--/title_box-->

<form name="form_informacoes" action="" method="post">   
    <?php
    if (isset($_POST['send']) && $_POST['send'] == 'Cadastrar') {

        $cadastraPagina['titulo'] = mysql_real_escape_string(strip_tags(trim($_POST['titulo'])));
        $cadastraPagina['tags'] = mysql_real_escape_string(strip_tags(trim($_POST['tags'])));
        $cadastraPagina['content'] = mysql_real_escape_string($_POST['content']);
        $cadastraPagina['url'] = setUri($cadastraPagina['titulo']);
        $cadastraPagina['data_criacao'] = date('Y-m-d H:1:s');

        if (in_array('', $cadastraPagina)) {
            echo '<div class="msg info borderradius5">Ooosp! Acho que esqueceu de preencher, existem campos em branco!</div>';
        } else {

            $verificaTitulo = read('paginas', "WHERE url='$cadastraPagina[url]'");

            if ($verificaTitulo) {
                echo '<div class="msg error borderradius5">Já existe uma página com esse título, por favor tente novamente.</div>';
            } else {

                $cadastraPaginaBanco = create('paginas', $cadastraPagina);
                if (!$cadastraPaginaBanco) {
                    echo '<div class="msg error borderradius5">Error! Entre em contato com o suporte!</div>';
                } else {
                    echo '<div class="msg ok borderradius5">Página cadastrada. Atualizando página...</div>';
                    echo '<script type="text/javascript">setTimeout(function(){location = "' . SITE . '/painel.php?pagina=paginas";}, 2000)</script>';
                }
            }
        }
    }
    ?>

    <label>
        <span class="span_titulo">Título</span>
        <input class="form_input borderradius5" name="titulo" value="<?= $_POST['titulo']; ?>">
    </label>
    <label>
        <span class="span_titulo">Conteúdo</span>        
        <textarea id="tiny" class="form_textareaContent borderradius5" name="content"><?= $_POST['content'] ?></textarea>
    </label>

    <div class="title_box borderradius5">SEO</div><!--/title_box-->
    <label>
        <span class="span_titulo">Palavras chaves <font style="font-size: 11px; margin-left: 10px; color: green;">Ex.: internet, web, sites, websites</font></span>
        <input class="form_input borderradius5" name="tags" value="<?= $_POST['tags']; ?>">
    </label>

    <input class="form_input_send borderradius5 send_categoria" type="submit" value="Cadastrar" name="send">
</form>