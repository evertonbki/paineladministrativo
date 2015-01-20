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
<div class="title_box borderradius5">Cadastrar Usuário</div><!--/title_box-->
<form name="form_informacoes" action="" method="post">

    <?php
    $editId = $_GET['editId'];

    $leituraUsuario = read('usuarios', "WHERE id = '$editId'");
    foreach ($leituraUsuario as $usuario)
        ;


    if (isset($_POST['send']) && $_POST['send'] == 'Editar') {


        $atualizaUsuario['nome'] = mysql_real_escape_string(strip_tags(trim($_POST['nome'])));
        $atualizaUsuario['email'] = mysql_real_escape_string(strip_tags(trim($_POST['email'])));
        $atualizaUsuario['telefone'] = mysql_real_escape_string(strip_tags(trim($_POST['telefone'])));
        $atualizaUsuario['login'] = mysql_real_escape_string(strip_tags(trim($_POST['login'])));
        $atualizaUsuario['recovery'] = mysql_real_escape_string(strip_tags(trim($_POST['senha'])));
        $atualizaUsuario['senha'] = mysql_real_escape_string(strip_tags(trim(md5($_POST['senha']))));


        if (in_array('', $atualizaUsuario)) {
            echo '<div class="msg info borderradius5">Existe campos em branco!</div>';
        } else {

            $verificarEmail = valMail($atualizaUsuario['email']);

            if ($verificarEmail) {
                if ($atualizaUsuario['login'] == $usuario['login']) {
                    $atualizaUsuarioBanco = update('usuarios', $atualizaUsuario, "id='$editId'");
                    if ($atualizaUsuarioBanco) {
                        echo '<div class="msg ok borderradius5">Usuário atualizado. Atualizando página...</div>';
                        echo '<script type="text/javascript">setTimeout(function(){location = "' . SITE . '/painel.php?pagina=usuarios";}, 2000)</script>';
                    } else {
                        echo '<div class="msg error borderradius5">Error! Entre em contato com o suporte!</div>';
                    }
                } else {

                    $verificaLogin = read('usuarios', "WHERE login ='$atualizaUsuario[login]'");
                    if ($verificaLogin) {
                        echo '<div class="msg error borderradius5">Login já existe, por favor utilize outro!</div>';
                    } else {
                        $upUsuarioBanco = update('usuarios', $atualizaUsuario, "id='$editId'");
                        if ($upUsuarioBanco) {
                            echo '<div class="msg ok borderradius5">Usuário atualizado. Atualizando página...</div>';
                            echo '<script type="text/javascript">setTimeout(function(){location = "' . SITE . '/painel.php?pagina=usuarios";}, 2000)</script>';
                        } else {
                            echo '<div class="msg error borderradius5">Error! Entre em contato com o suporte!</div>';
                        }
                    }
                }
            } else {
                echo '<div class="msg error borderradius5">E-mail inválido!</div>';
            }
        }
    }
    ?>

    <label>
        <span class="span_titulo">Nome Completo</span>
        <input class="form_input borderradius5" name="nome" value="<?= $usuario['nome'] ?>">
    </label>
    <label>
        <span class="span_titulo">E-mail</span>
        <input class="form_input borderradius5" name="email" value="<?= $usuario['email'] ?>">
    </label>
    <label>
        <span class="span_titulo">Telefone</span>
        <input class="form_input borderradius5" name="telefone" value="<?= $usuario['telefone'] ?>">
    </label>
    <label>
        <span class="span_titulo">Login</span>
        <input class="form_input borderradius5" name="login" value="<?= $usuario['login'] ?>">
    </label>
    <label>
        <span class="span_titulo">Senha</span>
        <input type="password" class="form_input borderradius5" name="senha" value="<?= $usuario['recovery'] ?>">
    </label>

    <input class="form_input_send borderradius5 edit_user" type="submit" value="Editar" name="send">
</form>