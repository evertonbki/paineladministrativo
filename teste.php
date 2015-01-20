<form name="form_informacoes" action="" method="post" enctype="multipart/form-data">
    <?php
    if (isset($_POST['send']) && $_POST['send'] == 'Cadastrar') {
        
        $arq = $_FILES['arq'];
        $permissao = array('image/jpg', 'image/jpeg', 'image/png');
        $ext = ($arq['type'] == 'image/png' ? '.png' : '.jpg');
        $size = 1024 * 1024 * 2;
        $pasta = 'uploads/galerias';
        $nome = md5(time()) . $ext;

        for ($i = 0; $i < count($arq['tmp_name']); $i++) {

            $arqNome = md5($arq['tmp_name'][$i]) . $ext;

            if ($arq['size'][$i] > $size) {
                echo '<div class="alert-box error"><span>error: </span>Arquivo não pode ser maior que 2Mb.</div>';
            } elseif (!in_array($arq['type'][$i], $permissao)) {
                echo '<div class="alert-box error"><span>error: </span>Apenas <strong>JPG</strong> ou <strong>PNG</strong>.</div>';
            }

            if (move_uploaded_file($arq['tmp_name'][$i], $pasta . '/' . $arqNome)) {
                echo '<div class="alert-box success"><span>successo: </span> ' . $arq['name'][$i] . ' enviado.</div>';

            } else {
                echo '<div class="alert-box error"><span>error: </span>Arquivo não enviado.</div>';
            }
        }
    }
    ?>    
    <label>
        <span class="span_titulo">Selecione suas imagens</span>
        <input type="file" name="arq[]" multiple />

    </label>

    <input class="form_input_send borderradius5 send_post" type="submit" value="Cadastrar" name="send">
</form>