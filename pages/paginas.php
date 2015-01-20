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
    <a class="a_cadastraPagina borderradius5" href="?pagina=cadastrar-pagina">Cadastrar Página</a>
    <a class="a_search borderradius5" href="?pagina=search-pagina">Procurar Página</a>
    <div class="clear"></div>
</nav>
<div class="title_box borderradius5">Lista de páginas</div><!--/title_box-->

<?php
$pag = ( $_GET['pag'] == 0 ? '1' : $_GET['pag']);
$maximo = 10;
$inicio = ($pag * $maximo) - $maximo;

$leituraPaginas = read('paginas', "ORDER BY id DESC LIMIT $inicio,$maximo");

if (!$leituraPaginas) {
    echo '<div class="msg info borderradius5">Nenhuma página cadastrada ainda.</div>';
} else {

    echo "<section class=\"table\">";
    echo "<table class=\"list_tabela\">";
    echo "<tr class=\"table_title\">";
    echo "<td width=\"444px\">Nome da Página</td>";
    echo "<td width=\"40px\">Tags</td>";
    echo "<td width=\"210px\">Data</td>";
    echo "<td width=\"286px\" colspan=\"3\">Ações</td>";
    echo "</tr>";

    $i = 1;
    foreach ($leituraPaginas as $pagina):

        echo "";
        echo ($i % 2 ? "<tr class=\"table_default\" style=\"background:#fff;\">" : "<tr class=\"table_default\">");

        echo "<td>" . $pagina['titulo'] . "</td>";
        echo "<td>";

        echo"<img src=\"" . (!empty($pagina['tags']) ? SITE . "/images/check-mark-8-16.png" : SITE . "/images/delete-2-16.png") . "\">";
        echo "</td>";
        echo "<td>" . $pagina['data_criacao'] . "</td>";
        echo "<td style=\"padding: 0; text-align: center;\"><a href=\"painel.php?pagina=editar-pagina&editId=".$pagina['id']."\" class=\"a_table_list a_edit borderradius5\"><span>Editar</span></a></td>";
        echo "<td style=\"padding: 0; text-align: center;\"><a href=\"painel.php?pagina=deletar-pagina&id=".$pagina['id']."\" class=\"a_table_list a_del borderradius5\"><span>Excluir</span></a></td>";
        echo "<td style=\"padding: 0; text-align: center;\"><a href=\"painel.php?pagina=cadastrar-galeria-pagina&id=".$pagina['id']."\" class=\"a_table_list a_gallery borderradius5\"><span>Galeria</span></a></td>";
        echo "</tr>";

        $i++;
    endforeach;

    echo "</table><!--/list_table-->";
    echo "</section><!--/table -->";

    $link = 'painel.php?pagina=paginas&pag=';
    readPaginator('paginas', "ORDER BY id DESC", $maximo, $link, $pag);
}
?>




