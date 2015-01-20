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
<nav class="nav_pages">
    <a class="a_cadastraPost borderradius5" href="?pagina=cadastrar-post">Cadastrar Post</a>
    <a class="a_search borderradius5 a_searchPost" href="#">Procurar Post</a>
    <div class="clear"></div>
    <?php 
        if(isset($_POST['send_search_paginas'])){
            $searchCategorias = mysql_real_escape_string(strip_tags(trim($_POST['search_categoria'])));
            echo '<script type="text/javascript">setTimeout(function(){location = "painel.php?pagina=search-post&s='.$searchCategorias.'";})</script>';         
        }
    ?>
    <form method="post" name="form_search_paginas" action="" class="search_posts" style="display: none;">
        <label>
            <input type="text" class="borderradius5" name="search_categoria" value="Palavra chave" onfocus="this.value = ''" onblur="if (this.value == '') {
                        this.value = 'Palavra chave'
                    }">
        </label>
        <input type="submit" name="send_search_paginas" class="send_searchPg" value="">
    </form>
</nav>
<div class="title_box borderradius5">Lista de posts</div><!--/title_box-->
<?php
$pag = ( $_GET['pag'] == 0 ? '1' : $_GET['pag']);
$maximo = 10;
$inicio = ($pag * $maximo) - $maximo;
$leituraPosts = read('posts',"ORDER BY id DESC LIMIT $inicio,$maximo");

if (!$leituraPosts) {
    echo '<div class="msg info borderradius5">Nenhum posta cadastrado ainda.</div>';
} else {

    echo "<section class=\"table\">";
    echo "<table class=\"list_tabela\">";
    echo "<tr class=\"table_title\">";
    echo "<td width=\"24px\" style=\"padding:0 3px; text-align: center;  font-size: 12px;\">OnOff</td>";
    echo "<td width=\"269px\">Titulo do Post</td>";
    echo "<td width=\"100px\">Ilustração</td>";
    echo "<td width=\"153px\">Categoria</td>";
    echo "<td width=\"40px\" style=\"padding:0; text-align:center;\">Tags</td>";
    echo "<td width=\"106px\">Data</td>";
    echo "<td width=\"286px\" colspan=\"3\">Ações</td>";
    echo "</tr>";

    $i = 1;
    foreach ($leituraPosts as $post):

        echo ($i % 2 ? "<tr class=\"table_default\" style=\"background:#fff;\">" : "<tr class=\"table_default\">");
        echo "<td style=\"padding: 0; text-align: center;\"><img src=\"images/" . ($post['status'] == '1' ? 'switch-on-24.png' : 'switch-off-24.png') . "\"></td>";
        echo "<td>" . $post['titulo'] . "</td>";
        echo "<td style=\" padding: 5px 0; text-align: center;\">";
        
        echo (!empty($post['ilustracao']) ? "<a href=\"".SITE."/uploads/capas/".$post['ilustracao']."\" rel=\"shadowbox\" \"><img src=\"".SITE."/timthumb.php?src=".SITE."/uploads/capas/".$post['ilustracao']."&w=100&h=90\" alt=\"\" width=\"100px\"></a>" : "<img src=\"".SITE."/timthumb.php?src=".SITE."/images/nopic.jpg&w=100&h=90\" alt=\"\" width=\"100px\">");
               
        echo "</td>";
        $readCategoria = read('categorias', "WHERE id ='$post[id_cat]'");
        if ($readCategoria) {
            foreach ($readCategoria as $categoria)
                ;
            echo '<td>' . $categoria['nome'] . '</td>';
        } else {
            echo '<td>sem categoria</td>';
        }
        echo "<td style=\"padding:0; text-align:center;\"><img src=\"images/" . (!empty($post['tags']) ? 'check-mark-8-16.png' : 'delete-2-16.png') . "\"></td>";
        echo "<td>" . formDate($post['data_criacao']) . "</td>";
        echo "<td style=\"padding: 0; text-align: center;\"><a href=\"painel.php?pagina=editar-post&editId=".$post['id']."\" class=\"a_table_list a_edit borderradius5\"><span>Editar</span></a></td>";
        echo "<td style=\"padding: 0; text-align: center;\"><a href=\"painel.php?pagina=deletar-post&id=".$post['id']."\" class=\"a_table_list a_del borderradius5\"><span>Excluir</span></a></td>";
        echo "<td style=\"padding: 0; text-align: center;\"><a href=\"painel.php?pagina=cadastrar-galeria-post&id=".$post['id']."\" class=\"a_table_list a_gallery borderradius5\"><span>Galeria</span></a></td>";
        echo "</tr>";
        $i++;
    endforeach;

    echo "</table><!--/list_table-->";
    echo "</section><!--/table -->";
    
    $link = 'painel.php?pagina=posts&pag=';   
    readPaginator('posts', "ORDER BY id DESC", $maximo, $link, $pag);
}
?>

