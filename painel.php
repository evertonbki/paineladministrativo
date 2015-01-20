<?php session_start(); ?>
<?php include ('./config/configs.php'); ?>
<?php include('./config/dbaSis.php'); ?>
<?php include ('./config/connection.php'); ?>
<?php
if (!empty($_SESSION['usuarioAutenticado'])) {
    $loginAutenticado = $_SESSION['usuarioAutenticado']['login'];
    $senhaAutenticada = $_SESSION['usuarioAutenticado']['senha'];

    $VereficaSessaoAutenticada = read('usuarios', "WHERE login='$loginAutenticado' AND senha='$senhaAutenticada'");
    foreach ($VereficaSessaoAutenticada as $usuarioAutenticado)
        ;
} else {
    echo '<script type="text/javascript">setTimeout(function(){location = "' . SITE . '/logout.php";}, 2000)</script>';
    header('location: ' . SITE . '/logout.php');
    die();
}
?>
<!DOCTYPE html> 
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Painel :: <?= NOMESITE; ?></title>        
        <link rel="shortcut icon" href="<?= SITE; ?>/images/faviconpainel.png">        
        <link rel="stylesheet" href="<?= SITE; ?>/css/style.css" type="text/css" media="screen" />
        <link href='http://fonts.googleapis.com/css?family=Righteous' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Comfortaa' rel='stylesheet' type='text/css'>
        <link href='js/shadowbox/shadowbox.css' rel='stylesheet' type='text/css'>

        <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
        <script src="js/shadowbox/shadowbox.js"></script>
        <script type="text/javascript">
            Shadowbox.init();
        </script>
        <script>
            $(function() {
                var po = '0';
                $('ul.list_sub_menu').hide();
                $('li.sub a').click(function() {
                    if (po == '0') {
                        $('ul.list_sub_menu').show();
                        $('ul.list_menu .sub').addClass('subaberto');
                        po = '1';
                    } else if (po == '1') {
                        $('ul.list_sub_menu').hide();
                        $('ul.list_menu .sub').removeClass('subaberto');
                        po = '0';
                    }
                });
            });
        </script>
        <script>
            $(function() {
                $('.paginator a, .paginator .atv').addClass('borderradius5');


                $('.a_searchCategorias').click(function() {
                    $('.search_categorias').slideDown();
                });
                
                $('.a_searchPost').click(function() {
                    $('.search_posts').slideDown();
                });

            });
        </script>

        <script src="js/tinymce/tinymce.min.js"></script>

        <script>
            tinymce.init({
                selector: 'textarea#tiny',
                language: 'pt_BR',
                plugins: [
                    "advlist autolink lists link image charmap print preview anchor",
                    "searchreplace visualblocks code fullscreen",
                    "insertdatetime media table contextmenu paste jbimages"
                ],
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image jbimages",
                relative_urls: false,
                remove_script_host: false
            });
        </script>
    </head>
    <body style="background: #fff;">
        <span class="text"></span>
        <header>
            <img src="<?= SITE . PASTATEMP . '/' . LOGO; ?>" width="200" alt="">
            <nav class="nav_top">
                <a href="?pagina=home" class="home borderradius5">Página Inicial</a>
                <a href="<?= SITE ?>/logout.php" class="exit borderradius5">Sair</a>
            </nav><!--/nav_top-->
        </header>
        <nav class="menu width borderradius5">
            <ul class="list_menu">
                <li><a href="?pagina=informacoes" title="">Informações Gerais</a></li>
                <li><a href="?pagina=usuarios" title="">Usuários</a></li>
                <li><a href="?pagina=categorias" title="">Categorias</a></li>
                <li><a href="?pagina=posts" title="">Posts</a></li>
                <li><a href="?pagina=paginas" title="">Páginas</a></li>
                <li class="no_border sub">
                    <a title="">Galerias</a>
                    <ul class="list_sub_menu borderradiusmenu">
                        <li><a href="?pagina=galeria-post">Posts</a></li>
                        <li class="no_border"><a href="?pagina=galeria-pagina">Páginas</a></li>
                    </ul>                
                </li>
            </ul>
            <div class="clear"></div>
        </nav><!--/menu -->
        <section class="wrap_all width">
            <?php
            if ($_GET['pagina']) {
                include('pages/' . $_GET['pagina'] . '.php');
            } else {
                include('pages/home.php');
            }
            ?>
            <footer>
                © 2011. Todos os direitos reservados
                <br>
                Desenvolvido por Everton Bronoski - Agência Ideia Três
            </footer>
        </section><!--/wrap_all-->



    </body>
</html>
