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
$s = $_GET['s'];
?>
<div class="title_box borderradius5">Resultado de pesquisa: <span style="color:#000;"><?= $s; ?></span></div><!--/title_box-->
<?php
if (isset($_POST['send_search_paginas'])) {
    $searchCategorias = mysql_real_escape_string($_POST['search_categoria']);
    echo '<script type="text/javascript">setTimeout(function(){location = "painel.php?pagina=search-categoria&s=' . $searchCategorias . '";})</script>';
}
?>
<form method="post" name="form_search_paginas" action="" class="search_categorias">
    <label>
        <input type="text" class="borderradius5" name="search_categoria" value="<?= $s; ?>" onfocus="this.value = ''" onblur="if (this.value == '') {
                    this.value = 'Palavra chave'
                }">
    </label>
    <input type="submit" name="send_search_paginas" class="send_searchPg" value="">
</form>

<?php
$pag = ( $_GET['pag'] == 0 ? '1' : $_GET['pag']);
$maximo = 10;
$inicio = ($pag * $maximo) - $maximo;
$LeituraCategorias = read('categorias', "WHERE nome LIKE '%$s%' ORDER BY id DESC LIMIT $inicio,$maximo");

if (!$LeituraCategorias) {
    echo '<span class="msg_no">Nenhuma categoria encontrada.</span>';
} else {
    echo '<section class="table">';
    echo '<table class="list_tabela">';
    echo '<tr class="table_title">';
    echo '<td width="245px">Nome Categoria</td>';
    echo '<td width="200px">Data de Criação</td>';
    echo '<td width="355px">Descrição</td>';
    echo '<td width="180px" colspan="2">Ações</td>';
    echo '</tr>';

    $i = 1;
    foreach ($LeituraCategorias as $categoria):

        if ($i % 2) {
            echo "<tr class=\"table_default\" style=\"background:#fff;\">";
        } else {
            echo "<tr class=\"table_default\">";
        }
        echo "<td>" . $categoria['nome'] . "</td>";
        echo "<td>" . formDate($categoria['data_criacao']) . "</td>";
        echo "<td>" . $categoria['descricao'] . "</td>";
        echo "<td style=\"padding: 0; text-align: center;\"><a href=\"painel.php?pagina=editar-categoria&editId=" . $categoria['id'] . "\" class=\"a_table_list a_edit borderradius5\"><span>Editar</span></a></td>";
        echo "<td style=\"padding: 0; text-align: center;\"><a href=\"painel.php?pagina=deletar-categoria&id=" . $categoria['id'] . "\" class=\"a_table_list a_del borderradius5\"><span>Excluir</span></a></td>";
        echo "</tr>";

        $i++;
    endforeach;

    echo '</table><!--/list_table-->';
    echo '</section><!--/table -->';
    echo '';
}

$link = 'painel.php?pagina=search-categoria&s=' . $s . '&pag=';
readPaginator('categorias', "WHERE nome LIKE '%$s%' ORDER BY id DESC", $maximo, $link, $pag);
?>