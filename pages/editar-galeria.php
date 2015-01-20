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
<div class="title_box borderradius5">Imagens da galeria</div><!--/title_box-->

<?php
$idDel = $_GET['idDel'];

$id = $_GET['id'];
$buscaCategoria = read('galerias', "WHERE id_post='$id'");
if(!$buscaCategoria){
    echo '<script type="text/javascript">setTimeout(function(){location = "' . SITE . '/painel.php?pagina=galeria-post";})</script>';
    die();
}

if (isset($_POST['sim']) && $_POST['sim'] == 'Sim') {
    
    $buscaGaleriaDel = read('galerias',"WHERE id=$idDel");
    if($buscaGaleriaDel){foreach($buscaGaleriaDel as $delGaleria);}
    
    
    $pasta = ('uploads/galerias/');
    $arquivo = $delGaleria['imagem'];
    $imagemDel = $pasta . $arquivo;
    
    if(!unlink($imagemDel)){
        
        echo 'error';
        
    }else{
        
        $deletarImagem = delete('galerias', "id='$idDel'");
        if(!$deletarImagem){
            echo '<div class="msg ok borderradius5" style="width:280px;margin:20px auto;">Imagem deletada. Atualizando página...</div>';
            echo '<script type="text/javascript">setTimeout(function(){location = "' . SITE . '/painel.php?pagina=editar-galeria&id='.$id.'";}, 2000)</script>';
        }else{
            echo 'error';
        }
        
    }
    
}


if (!empty($_GET['idDel'])) {

    echo "<span class=\"text_del\">Você realmente deseja <strong>excluir</strong> essa imagem?</span>";
    echo "<form name=\"DelFoto\" action=\"\" method=\"post\">";
    echo "<input type=\"submit\" class=\"form_input_send send_del borderradius5\" name=\"sim\" value=\"Sim\">";
    echo "<br>";
    echo "<a href=\"painel.php?pagina=editar-galeria&id=" . $id . "\" class=\"no_del borderradius5\">Não</a>";
    echo "</form>";
}
?>

<ul class="list_galeria">

<?php
$i = 1;
foreach ($buscaCategoria as $postGaleria):

    echo "<li " . ($i == 9 ? 'style=\"margin:0 !important;\"' : '') . ">";
    echo "<img src=\"" . SITE . "/timthumb.php?src=" . SITE . "/uploads/galerias/" . $postGaleria['imagem'] . "&w=100&h=100\" alt=\"\" width=\"100\">";
    echo "<a href=\"painel.php?pagina=editar-galeria&id=" . $id . "&idDel=" . $postGaleria['id'] . "\" class=\"a_excluir_imagem borderradius5\">Excluir</a>";
    echo "</li>";

    $i++;
endforeach;
?>

</ul>
<div class="clear"></div>
