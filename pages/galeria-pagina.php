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
<div class="title_box borderradius5">Lista de Galerias de Posts</div><!--/title_box-->

<?php
$pag = ( $_GET['pag'] == 0 ? '1' : $_GET['pag']);
$maximo = 10;
$inicio = ($pag * $maximo) - $maximo;
$leituraGaleriasPost = read('galerias', "WHERE id_post='0' GROUP BY id_pagina ORDER BY id DESC LIMIT $inicio,$maximo");

if(!$leituraGaleriasPost){
    echo '<div class="msg info borderradius5">Nenhum galeria de página cadastrada ainda.</div>';
}else{
    
    echo "<section class=\"table\">";
    echo "<table class=\"list_tabela\">";
    echo "<tr class=\"table_title\">";
    echo "<td width=\"444px\">Título de Post</td>";    
    echo "<td width=\"250px\">Data</td>";
    echo "<td width=\"286px\" colspan=\"2\">Ações</td>";
    echo "</tr>";
    
    
    foreach($leituraGaleriasPost as $galeria):
        
        echo "<tr class=\"table_default\" style=\"<?= ($i % 2) ? 'background:#fff;' : ''; ?>\">";
    
        $buscaPagina = read('paginas',"WHERE id='$galeria[id_pagina]'");
   
        if($buscaPagina){ 
                foreach($buscaPagina as $pagina);
                echo "<td>".$pagina['titulo']."</td>";
            }
               
        echo "<td>".$galeria['data_criacao']."</td>";
        echo "<td style=\"padding: 0; text-align: center;\"><a href=\"#\" class=\"a_table_list a_edit borderradius5\"><span>Editar</span></a></td>";
        echo "<td style=\"padding: 0; text-align: center;\"><a href=\"painel.php?pagina=deletar-galeria-pagina&id=".$pagina['id']."\" class=\"a_table_list a_del borderradius5\"><span>Excluir</span></a></td>";
        echo "</tr>";
        
    endforeach;
    
    echo "</table><!--/list_table-->";
    echo "</section><!--/table -->";
    
    $link = 'painel.php?pagina=galeria-pagina&pag=';   
    readPaginator('galerias', "WHERE id_post='0' GROUP BY id_pagina ORDER BY id DESC", $maximo, $link, $pag);
    
}

?>