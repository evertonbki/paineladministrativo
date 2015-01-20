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
$editId = $_GET['editId'];

$buscaPost = read('posts', "WHERE id='$editId'");
foreach ($buscaPost as $post)
    ;
?>


<div class="title_box borderradius5">Editar Post</div><!--/title_box-->
<form name="form_informacoes" action="" method="post" enctype="multipart/form-data">
    <?php
    if (isset($_POST['send']) && $_POST['send'] == 'Editar') {

        $editaPost['id_cat'] = mysql_real_escape_string(strip_tags($_POST['categoria']));
        $editaPost['titulo'] = mysql_real_escape_string(strip_tags($_POST['titulo']));
        $editaPost['url'] = mysql_real_escape_string(strip_tags(setUri($_POST['titulo'])));
        $editaPost['content'] = mysql_real_escape_string($_POST['content']);
        $editaPost['tags'] = mysql_real_escape_string(strip_tags($_POST['tags']));
        $editaPost['data_modificacao'] = date('Y-m-d H:1:s');
        $editaPost['status'] = mysql_real_escape_string(strip_tags($_POST['status']));


        if (in_array('', $editaPost)) {
            echo '<div class="msg info borderradius5">Ooosp! Acho que esqueceu de preencher, existem campos em branco!</div>';
        } else {

            $editaPost['ilustracao'] = $_FILES['capa'];
            if (!empty($editaPost['ilustracao']['name'])) {               

                $permisoes = array('image/jpg', 'image/jpeg', 'image/png');
                $extensao = ($editaPost['ilustracao']['type'] == 'image/png' ? '.png' : '.jpg');
                $size = 1024 * 1024 * 2;
                $pasta = 'uploads/capas';
                $imgTmp = $editaPost['ilustracao']['tmp_name'];
                $imgNome = $editaPost['url'] . '-' . md5(time()) . $extensao;

                if (!empty($post['ilustracao'])) {

                    $pasta = ('uploads/capas/');
                    $arquivo = $post['ilustracao'];
                    $ilustracao = $pasta . $arquivo;

                    $delImagem = unlink($ilustracao);
                    
                    echo (!$delImagem ? '<div class="msg error borderradius5" style="width:280px;margin:20px auto;">Error! Entre em contato com o suporte!</div>':'');
                    
                }
                
                if ($editaPost['ilustracao']['size'] > $size) {
                        echo '<div class="msg info borderradius5">Ooosp! Sua imagem de capa só pode ter 2mb!</div>';
                    } elseif (!in_array($editaPost['ilustracao']['type'], $permisoes)) {
                        echo '<div class="msg info borderradius5">Desculpa! Mas só é aceito imagens jpg ou png.</div>';
                    } else {

                        if ($extensao == '.jpg') {

                            $uploadJpg = uploadImg($imgTmp, $imgNome, 800, $pasta);

                            if ($uploadJpg) {
                                $editaPost['ilustracao'] = $imgNome;
                                $editaPostBancoIlustracaoJpg = update('posts', $editaPost,"id='$editId'");

                                if ($editaPostBancoIlustracaoJpg) {
                                    echo '<div class="msg ok borderradius5">Post atualizado. Atualizando página...</div>';
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
                                $editaPost['ilustracao'] = $imgNome;
                                $editaPostBancoIlustracaoPng = update('posts', $editaPost,"id='$editId'");

                                if ($cadastraPostBancoIlustracaoPng) {
                                    echo '<div class="msg ok borderradius5">Post atualizado. Atualizando página...</div>';
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

                if ($editaPost['url'] == $post['url']) {

                    $editaPost['ilustracao'] = $post['ilustracao'];
                    $editaPostBancoSemIlustracao = update('posts', $editaPost, "id='$editId'");
                    if ($editaPostBancoSemIlustracao) {
                        echo '<div class="msg ok borderradius5">Post atualizado. Atualizando página...</div>';
                        echo '<script type="text/javascript">setTimeout(function(){location = "' . SITE . '/painel.php?pagina=posts";}, 2000)</script>';
                    } else {
                        echo '<div class="msg error borderradius5">Error! Entre em contato com o suporte!</div>';
                    }
                } else {
                    $verificaTitulo = read('posts', "WHERE url='$editaPost[url]'");
                    if ($verificaTitulo) {
                        echo '<div class="msg error borderradius5">Já existe um post com esse título, por favor tente novamente.</div>';
                    } else {
                        $editaPost['ilustracao'] = $post['ilustracao'];
                        $editaPostBancoSemIlustracao = update('posts', $editaPost, "id='$editId'");
                        if ($editaPostBancoSemIlustracao) {
                            echo '<div class="msg ok borderradius5">Post atualizado. Atualizando página...</div>';
                            echo '<script type="text/javascript">setTimeout(function(){location = "' . SITE . '/painel.php?pagina=posts";}, 2000)</script>';
                        } else {
                            echo '<div class="msg error borderradius5">Error! Entre em contato com o suporte!</div>';
                        }
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
        echo '<option ' . ($post['id_cat'] == $categoria['id'] ? 'selected' : '') . ' value="' . $categoria['id'] . '">' . $categoria['nome'] . '</option>';
    endforeach;
}
?>
        </select>
    </label>
    <br />
    <div class="title_box borderradius5">Capa</div><!--/title_box-->
    <label>
        <span class="span_titulo">Título</span>
        <input class="form_input borderradius5" name="titulo" value="<?= $post['titulo']; ?>">
    </label>
    <label>
<?php
if (empty($post['ilustracao'])) {
    echo '<span class="span_titulo">Imagem de capa</span>';
    echo '<input type="file" name="capa">';
} else {
    echo '<br />';
    echo '<a href="' . SITE . '/uploads/capas/' . $post['ilustracao'] . '" rel="shadowbox">';
    echo '<img src="' . SITE . '/timthumb.php?src=' . SITE . '/uploads/capas/' . $post['ilustracao'] . '&w=100&h=90" />';
    echo '</a>';
    echo '<br />';
    echo '<br />';
    echo '<span class="span_titulo">Escolher outra imagem de capa</span>';
    echo '<input type="file" name="capa">';
}
?>        
    </label>
    <br />
    <div class="title_box borderradius5">Status</div><!--/title_box-->
    <label>
        <span class="span_titulo">Escolha o status</span>
        <label style="background: #e1e1e1;" class="borderradius5"><input type="radio" name="status" value="1" <?= ($post['status'] == '1' ? 'checked="checked"' : ''); ?>    class="form_input_radio"><span class="form_span"><strong>Publicado</strong> <span style="font-size: 12px;">(Seu post será visível a todos)</span></span><br /></label>
        <label style="background: #e1e1e1;" class="borderradius5"><input type="radio" name="status" value="0" <?= ($post['status'] == '0' ? 'checked="checked"' : ''); ?> class="form_input_radio"><span class="form_span"><strong>Rascunho</strong> <span style="font-size: 12px;">(Post visível somente na área administrativa)</span></span></label>
    </label>

    <br />
    <div class="title_box borderradius5">Conteúdo do seu Post</div><!--/title_box-->
    <label>
        <span class="span_titulo">Conteúdo</span>        
        <textarea id="tiny" class="form_textareaContent borderradius5" name="content"><?= $post['content']; ?></textarea>
    </label>

    <br />
    <div class="title_box borderradius5">SEO</div><!--/title_box-->
    <label>
        <span class="span_titulo">Palavras chaves <font style="font-size: 11px; margin-left: 10px; color: green;">Ex.: internet, web, sites, websites</font></span>
        <input class="form_input borderradius5" name="tags" value="<?= $post['tags']; ?>">
    </label>

    <input class="form_input_send borderradius5 send_post" type="submit" value="Editar" name="send">
</form>