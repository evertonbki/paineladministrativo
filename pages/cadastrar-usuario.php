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
    if (isset($_POST['send']) && $_POST['send'] == 'Cadastrar') {

        $cadastraUsuario['nome'] = mysql_real_escape_string(strip_tags(trim($_POST['nome'])));
        $cadastraUsuario['email'] = mysql_real_escape_string(strip_tags(trim($_POST['email'])));
        $cadastraUsuario['telefone'] = mysql_real_escape_string(strip_tags(trim($_POST['telefone'])));
        $cadastraUsuario['login'] = mysql_real_escape_string(strip_tags(trim($_POST['login'])));
        $cadastraUsuario['senha'] = mysql_real_escape_string(strip_tags(trim(md5($_POST['senha']))));
        $cadastraUsuario['recovery'] = mysql_real_escape_string(strip_tags(trim($_POST['senha'])));
        $cadastraUsuario['data_criacao'] = date('Y-m-d H:i');

        if (in_array('', $cadastraUsuario)) {
            echo '<div class="msg info borderradius5">Existem campos em branco!</div>';
        } else {
            $verificarEmail = valMail($cadastraUsuario['email']);
            if ($verificarEmail) {

                $vericaExistenciaUsuario = read('usuarios', "WHERE login='$cadastraUsuario[login]'");

                if ($vericaExistenciaUsuario) {
                    echo '<div class="msg error borderradius5">Login já existe, por favor utilize outro!</div>';
                } else {
                    $CadastraUsuarioBanco = create('usuarios', $cadastraUsuario);
                    if ($CadastraUsuarioBanco) {
                        echo '<div class="msg ok borderradius5">Usuário cadastrando. Atualizando página...</div>';
                        echo '<script type="text/javascript">setTimeout(function(){location = "' . SITE . '/painel.php?pagina=usuarios";}, 2000)</script>';
                    } else {
                        echo '<div class="msg error borderradius5">Error! Entre em contato com o suporte!</div>';
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
        <input class="form_input borderradius5" name="nome" value="<?= ($_POST['nome']) ? $_POST['nome'] : ''; ?>">
    </label>
    <label>
        <span class="span_titulo">E-mail</span>
        <input class="form_input borderradius5" name="email" value="<?= ($_POST['email']) ? $_POST['email'] : ''; ?>">
    </label>
    <label>
        <span class="span_titulo">Telefone</span>
        <input class="form_input borderradius5" name="telefone" value="<?= ($_POST['telefone']) ? $_POST['telefone'] : ''; ?>">
    </label>
    <label>
        <span class="span_titulo">Login</span>
        <input class="form_input borderradius5" name="login" value="<?= ($_POST['login']) ? $_POST['login'] : ''; ?>">
    </label>
    <label>
        <span class="span_titulo">Senha</span>
        <input type="password" class="form_input borderradius5" name="senha" value="<?= ($_POST['senha']) ? $_POST['senha'] : ''; ?>">
    </label>

    <input class="form_input_send borderradius5 send_user" type="submit" value="Cadastrar" name="send">
</form>