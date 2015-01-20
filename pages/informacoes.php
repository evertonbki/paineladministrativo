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
<?php
$buscarInformacoes = read('informacoes');
foreach ($buscarInformacoes as $informacoes)
    ;
?>
<form name="form_informacoes" action="" method="post">

    <?php
    if (isset($_POST['send']) && $_POST['send'] == 'Atualizar') {

        $atualizaInformacoes['id'] = $informacoes['id'];
        $atualizaInformacoes['email'] = mysql_real_escape_string(strip_tags($_POST['email']));
        $atualizaInformacoes['endereco'] = mysql_real_escape_string(strip_tags($_POST['endereco']));
        $atualizaInformacoes['telefone'] = mysql_real_escape_string(strip_tags($_POST['telefone']));
        $atualizaInformacoes['descricao'] = mysql_real_escape_string(strip_tags($_POST['descricao']));
        $atualizaInformacoes['tags'] = mysql_real_escape_string(strip_tags($_POST['tags']));
        $atualizaInformacoes['titulo'] = mysql_real_escape_string(strip_tags($_POST['titulo']));
        $atualizaInformacoes['google_maps'] = mysql_real_escape_string(strip_tags($_POST['google_maps']));
        $atualizaInformacoes['google_analytics'] = mysql_real_escape_string(strip_tags($_POST['google_analytics']));
        $atualizaInformacoes['facebook'] = mysql_real_escape_string(strip_tags($_POST['facebook']));
        $atualizaInformacoes['twitter'] = mysql_real_escape_string(strip_tags($_POST['twitter']));
        $atualizaInformacoes['youtube'] = mysql_real_escape_string(strip_tags($_POST['youtube']));


        $verificarEmail = valMail($atualizaInformacoes['email']);

        if (in_array('', $atualizaInformacoes)) {
            echo '<div class="msg info borderradius5">Existem campos em branco!</div>';
        } else {
            if ($verificarEmail) {
                $atualizaInformacoes = update('informacoes', $atualizaInformacoes, "id= '$atualizaInformacoes[id]'");
                if ($atualizaInformacoes) {
                    echo '<div class="msg ok borderradius5">Informações atualizadas. Atualizando página...</div>';
                    echo '<script type="text/javascript">setTimeout(function(){location = "' . SITE . '/painel.php?pagina=informacoes";}, 2000)</script>';
                } else {
                    echo '<div class="msg error borderradius5">Error! Entre em contato com o suporte!</div>';
                }
            } else {
                echo '<div class="msg info borderradius5">E-mail inválido!</div>';
            }
        }
    }
    ?>

    <div class="title_box borderradius5">Gerais</div><!--/title_box-->
    <label>
        <span class="span_titulo">E-mail</span>
        <input class="form_input borderradius5" name="email" value="<?= $informacoes[email]; ?>">
    </label>
    <label>
        <span class="span_titulo">Endereço</span>
        <input class="form_input borderradius5" name="endereco" value="<?= $informacoes[endereco]; ?>">
    </label>
    <label>
        <span class="span_titulo">Telefone</span>
        <input class="form_input borderradius5" name="telefone" value="<?= $informacoes[telefone]; ?>">
    </label>
    <br>
    <div class="title_box borderradius5">SEO</div><!--/title_box-->
    <label>
        <span class="span_titulo">Descrição</span>
        <input class="form_input borderradius5" name="descricao" value="<?= $informacoes[descricao]; ?>">
    </label>
    <label>
        <span class="span_titulo">Palavras chaves</span>
        <input class="form_input borderradius5" name="tags" value="<?= $informacoes[tags]; ?>">
    </label>
    <label>
        <span class="span_titulo">Título do site</span>
        <input class="form_input borderradius5" name="titulo" value="<?= $informacoes[titulo]; ?>">
    </label>
    <label>
        <span class="span_titulo">Google Maps</span>        
        <textarea class="form_textarea borderradius5" name="google_maps"><?= $informacoes[google_maps]; ?></textarea>
    </label>
    <label>
        <span class="span_titulo">Google Analytics</span>        
        <textarea class="form_textarea borderradius5" name="google_analytics"><?= $informacoes[google_analytics]; ?></textarea>
    </label>

    <br>
    <div class="title_box borderradius5">Redes Sociais</div><!--/title_box-->
    <label>
        <span class="span_titulo">Facebook</span>
        <input class="form_input borderradius5" name="facebook" value="<?= $informacoes[facebook]; ?>">
    </label>
    <label>
        <span class="span_titulo">Twitter</span>
        <input class="form_input borderradius5" name="twitter" value="<?= $informacoes[twitter]; ?>">
    </label>
    <label>
        <span class="span_titulo">Youtube</span>
        <input class="form_input borderradius5" name="youtube" value="<?= $informacoes[youtube]; ?>">
    </label>
    <input class="form_input_send borderradius5" type="submit" value="Atualizar" name="send">
</form>