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
<div class="title_box borderradius5">Cadastrar Categoria</div><!--/title_box-->

<form name="form_informacoes" action="" method="post">
    <?php
    if (isset($_POST['send']) && $_POST['send'] == 'Cadastrar') {

        $cadastraCategoria['nome'] = mysql_real_escape_string(strip_tags(trim($_POST['titulo'])));
        $cadastraCategoria['descricao'] = mysql_real_escape_string(strip_tags(trim($_POST['descricao'])));
        $cadastraCategoria['data_criacao'] = date('Y-m_d H:1');
        $cadastraCategoria['url'] = setUri($cadastraCategoria['nome']);

        if (in_array('', $cadastraCategoria)) {
            echo '<div class="msg info borderradius5">Ooops! Existem campos em branco!</div>';
        } else {
            $verificaCategoria = read('categorias', "WHERE url='$cadastraCategoria[url]'");
            if ($verificaCategoria) {
                echo '<div class="msg error borderradius5">Título já existe, por favor utilize outro!</div>';
            } else {

                $cadastraCategoriaBanco = create('categorias', $cadastraCategoria);
                if ($cadastraCategoriaBanco) {
                    echo '<div class="msg ok borderradius5">Categoria cadastrada. Atualizando página...</div>';
                    echo '<script type="text/javascript">setTimeout(function(){location = "' . SITE . '/painel.php?pagina=categorias";}, 2000)</script>';
                } else {
                    echo '<div class="msg error borderradius5">Error! Entre em contato com o suporte!</div>';
                }
            }

        }
    }
    ?>
    <label>
        <span class="span_titulo">Título da categoria</span>
        <input class="form_input borderradius5" name="titulo">
    </label>
    <label>
        <span class="span_titulo">Descrição</span>        
        <textarea class="form_textarea borderradius5" name="descricao"></textarea>
    </label>    
    <input class="form_input_send borderradius5 send_categoria" type="submit" value="Cadastrar" name="send">
</form>