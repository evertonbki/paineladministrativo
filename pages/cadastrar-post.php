<?php
if (!empty($_SESSION['usuarioAutenticado'])) {
    $loginAutenticado = $_SESSION['usuarioAutenticado']['login'];
    $senhaAutenticada = $_SESSION['usuarioAutenticado']['senha'];

    $VereficaSessaoAutenticada = read('usuarios', "WHERE login='$loginAutenticado' AND senha='$senhaAutenticada'");
    foreach ($VereficaSessaoAutenticada as $usuarioAutenticado);
} else {
    echo '<script type="text/javascript">setTimeout(function(){location = "..//logout.php";}, 2000)</script>';
    header('location: ../logout.php');
    die();
}
?>
<div class="title_box borderradius5">Cadastrar Post</div><!--/title_box-->
<form name="form_informacoes" action="" method="post" enctype="multipart/form-data">
    <?php
    if (isset($_POST['send']) && $_POST['send'] == 'Cadastrar') {

        $cadastraPost['id_cat'] = mysql_real_escape_string(strip_tags($_POST['categoria']));
        $cadastraPost['titulo'] = mysql_real_escape_string(strip_tags($_POST['titulo']));
        $cadastraPost['url'] = mysql_real_escape_string(strip_tags(setUri($_POST['titulo'])));
        $cadastraPost['content'] = mysql_real_escape_string($_POST['content']);
        $cadastraPost['tags'] = mysql_real_escape_string(strip_tags($_POST['tags']));
        $cadastraPost['data_criacao'] = date('Y-m-d H:1:s');
        $cadastraPost['status'] = mysql_real_escape_string(strip_tags($_POST['status']));

        if (in_array('', $cadastraPost)) {
            echo '<div class="msg info borderradius5">Ooosp! Acho que esqueceu de preencher, existem campos em branco!</div>';
        } else {

            $verificaTitulo = read('posts', "WHERE url='$cadastraPost[url]'");

            if ($verificaTitulo) {
                echo '<div class="msg error borderradius5">Já existe um post com esse título, por favor tente novamente.</div>';
            } else {

                $cadastraPost['ilustracao'] = $_FILES['capa'];
                if (!empty($cadastraPost['ilustracao']['name'])) {

                    $permisoes = array('image/jpg', 'image/jpeg', 'image/png');
                    $extensao = ($cadastraPost['ilustracao']['type'] == 'image/png' ? '.png' : '.jpg');
                    $size = 1024 * 1024 * 2;
                    $pasta = 'uploads/capas';
                    $imgTmp = $cadastraPost['ilustracao']['tmp_name'];
                    $imgNome = $cadastraPost['url'] . '-' . md5(time()) . $extensao;

                    if ($cadastraPost['ilustracao']['size'] > $size) {
                        echo '<div class="msg info borderradius5">Ooosp! Sua imagem de capa só pode ter 2mb!</div>';
                    } elseif (!in_array($cadastraPost['ilustracao']['type'], $permisoes)) {
                        echo '<div class="msg info borderradius5">Desculpa! Mas só é aceito imagens jpg ou png.</div>';
                    } else {

                        if ($extensao == '.jpg') {

                            $uploadJpg = uploadImg($imgTmp, $imgNome, 800, $pasta);

                            if ($uploadJpg) {
                                $cadastraPost['ilustracao'] = $imgNome;
                                $cadastraPostBancoIlustracaoJpg = create('posts', $cadastraPost);

                                if ($cadastraPostBancoIlustracaoJpg) {
                                    echo '<div class="msg ok borderradius5">Post cadastrado. Atualizando página...</div>';
                                    echo '<script type="text/javascript">setTimeout(function(){location = "' . SITE . '/painel.php?pagina=posts";}, 2000)</script>';
                                } else {
                                    echo '<div class="msg error borderradius5">Error! Entre em contato com o suporte!</div>';
                                }
                            } else {
                                echo '<div class="msg error borderradius5">Error! Entre em contato com o suporte!</div>';
                            }
                        } elseif ($extensao == '.png') {

                            $uploadPng = uploadImgPng($imgTmp, $imgNome, 800, $pasta);

                            if ($uploadPng) {
                                $cadastraPost['ilustracao'] = $imgNome;
                                $cadastraPostBancoIlustracaoPng = create('posts', $cadastraPost);

                                if ($cadastraPostBancoIlustracaoPng) {
                                    echo '<div class="msg ok borderradius5">Post cadastrado. Atualizando página...</div>';
                                    echo '<script type="text/javascript">setTimeout(function(){location = "' . SITE . '/painel.php?pagina=posts";}, 2000)</script>';
                                } else {
                                    echo '<div class="msg error borderradius5">Error! Entre em contato com o suporte!</div>';
                                }
                            } else {
                                echo '<div class="msg error borderradius5">Error! Entre em contato com o suporte!</div>';
                            }
                        }
                    }
                } else {
                    $cadastraPost['ilustracao'] = null;
                    $cadastraPostBancoSemIlustracao = create('posts', $cadastraPost);
                    if ($cadastraPostBancoSemIlustracao) {
                        echo '<div class="msg ok borderradius5">Post cadastrado. Atualizando página...</div>';
                        echo '<script type="text/javascript">setTimeout(function(){location = "' . SITE . '/painel.php?pagina=posts";}, 2000)</script>';
                    } else {
                        echo '<div class="msg error borderradius5">Error! Entre em contato com o suporte!</div>';
                    }
                }
            }
        }
    }
    ?>
    <label>
        <span class="span_titulo">Categoria</span>
        <select name="categoria" class="form_select borderradius5">
            <?php
            $buscaCategoria = read('categorias');
            if ($buscaCategoria) {
                foreach ($buscaCategoria as $categoria):
                    echo '<option value="' . $categoria['id'] . '">' . $categoria['nome'] . '</option>';
                endforeach;
            }
            ?>
        </select>
    </label>
    <br />
    <div class="title_box borderradius5">Capa</div><!--/title_box-->
    <label>
        <span class="span_titulo">Título</span>
        <input class="form_input borderradius5" name="titulo" value="<?= $_POST['titulo']; ?>">
    </label>
    <label>
        <span class="span_titulo">Imagem de capa</span>
        <input type="file" name="capa">
    </label>

    <br />
    <div class="title_box borderradius5">Status</div><!--/title_box-->
    <label>
        <span class="span_titulo">Escolha o status</span>
        <label style="background: #e1e1e1;" class="borderradius5"><input type="radio" name="status" value="1" class="form_input_radio"><span class="form_span"><strong>Publicado</strong> <span style="font-size: 12px;">(Seu post será visível a todos)</span></span><br /></label>
        <label style="background: #e1e1e1;" class="borderradius5"><input type="radio" name="status" value="0" checked="checked" class="form_input_radio"><span class="form_span"><strong>Rascunho</strong> <span style="font-size: 12px;">(Post visível somente na área administrativa)</span></span></label>
    </label>

    <br />
    <div class="title_box borderradius5">Conteúdo do seu Post</div><!--/title_box-->
    <label>
        <span class="span_titulo">Conteúdo</span>        
        <textarea id="tiny" class="form_textareaContent borderradius5" name="content"><?= $_POST['content']; ?></textarea>
    </label>

    <br />
    <div class="title_box borderradius5">SEO</div><!--/title_box-->
    <label>
        <span class="span_titulo">Palavras chaves <font style="font-size: 11px; margin-left: 10px; color: green;">Ex.: internet, web, sites, websites</font></span>
        <input class="form_input borderradius5" name="tags" value="<?= $_POST['tags']; ?>">
    </label>

    <input class="form_input_send borderradius5 send_post" type="submit" value="Cadastrar" name="send">
</form>