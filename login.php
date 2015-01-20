<?php session_start(); ?>
<?php include ('./config/configs.php'); ?>
<?php include('./config/dbaSis.php'); ?>
<?php include ('./config/connection.php'); ?>
<?php
if (!empty($_SESSION['usuarioAutenticado'])) {
    $loginAutenticado = $_SESSION['usuarioAutenticado']['login'];
    $senhaAutenticada = $_SESSION['usuarioAutenticado']['senha'];

    $VereficaSessaoAutenticada = read('usuarios', "WHERE login='$loginAutenticado' AND senha='$senhaAutenticada'");

    if ($VereficaSessaoAutenticada) {

        echo '<script type="text/javascript">setTimeout(function(){location = "' . SITE . '/painel.php";}, 2000)</script>';
        header('location: ' . SITE . '/painel.php');
        die();
    } else {
        echo '<script type="text/javascript">setTimeout(function(){location = "' . SITE . '/logout.php";}, 2000)</script>';
        header('location: ' . SITE . '/logout.php');
        die();
    }
}
?>

<!DOCTYPE html> 
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="robots" content="noindex, nofollow">
        <title>Login :: <?= NOMESITE; ?></title>        
        <link rel="shortcut icon" href="<?= SITE; ?>/images/favicon.png">        
        <link rel="stylesheet" href="<?= SITE; ?>/css/style.css" type="text/css" media="screen" />
        <link href='http://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <nav class="top"><?= NOMESITE; ?></nav><!--/top-->           
        <section class="login">
            <div class="logo">
                <img src="<?= SITE . PASTATEMP . '/' . LOGO; ?>" width="200" alt="">
                <div style="display: none;">
                    <div class="msg ok borderradius5">Usuário autenticado! Entrando...</div>
                    <div class="msg info borderradius5">Usuário ou senha incorreto!</div>
                    <div class="msg error borderradius5">Error! Entre em contato com o suporte!</div>
                </div>
            </div><!--/logo-->           
            <form name="form_login" action="" method="post">
                <?php
                if (isset($_POST['send']) && $_POST['send'] == 'Entrar') {
                    $login = mysql_real_escape_string(trim($_POST['login']));
                    $senha = mysql_real_escape_string($_POST['senha']);

                    if ($login == '' || $senha == '') {
                        echo '<div class="msg info borderradius5">Ooops, campos em branco.</div>';
                    } else {

                        $vereficarLogin = read('usuarios', "WHERE login='$login'");

                        if ($vereficarLogin) {
                            $senha = md5($senha);
                            $verificarAutenticidade = read('usuarios', "WHERE login='$login' AND senha='$senha'");
                            if ($verificarAutenticidade) {
                                foreach ($verificarAutenticidade as $usuarioAutenticado)
                                    ;
                                $_SESSION['usuarioAutenticado'] = $usuarioAutenticado;

                                echo '<div class="msg ok borderradius5">Usuário autenticado! Entrando...</div>';
                                echo '<script type="text/javascript">setTimeout(function(){location = "' . SITE . '/painel.php";}, 2000)</script>';
                                header('location: ' . SITE . '/painel.php');
                                die();
                            } else {
                                echo '<div class="msg error borderradius5">Login e senha incorreto!</div>';
                            }
                        } else {
                            echo '<div class="msg error borderradius5">Usuário não Existe! Tente novamente.</div>';
                        }
                    }
                }
                ?>
                <label>
                    <input type="text" name="login" value="Login" class="borderradius5" onfocus="this.value = ''" onblur="if (this.value == '') {
                                this.value = 'Login'
                            }">
                </label>
                <label>
                    <input type="password" name="senha" class="borderradius5">
                </label>
                <input type="submit" name="send" value="Entrar" class="borderradius5 send">
            </form>
        </section><!--/login-->
    </body>
</html>
