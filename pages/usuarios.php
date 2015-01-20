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
<div class="title_box borderradius5">Lista de usuários</div><!--/title_box-->

<nav class="nav_pages">
    <a class="a_cadastra borderradius5" href="?pagina=cadastrar-usuario">Cadastrar Usuário</a>
    <div class="clear"></div>
</nav>

<section class="table">
    <table class="list_tabela">
        <tr class="table_title">
            <td width="190px">Nome Completo</td>
            <td width="100px">Login</td>
            <td width="145px">Telefone</td>
            <td width="345px">E-mail</td>
            <td width="200px" colspan="2">Ações</td>
        </tr>

        <?php
        $buscaUsuarios = read('usuarios', "ORDER BY id DESC");
        $i = 1;
        foreach ($buscaUsuarios as $usuario):
            if ($i % 2) {
                echo '<tr class="table_default" style="background:#fff;">';
            } else {
                echo '<tr class="table_default">';
            }
            echo "<td>" . $usuario['nome'] . "</td>";
            echo "<td>" . $usuario['login'] . "</td>";
            echo "<td>" . $usuario['telefone'] . "</td>";
            echo "<td>" . $usuario['email'] . "</td>";
            echo "<td style=\"padding: 0; text-align: center;\"><a href=\"?pagina=editar-usuario&editId=".$usuario['id']."\" class=\"a_table_list a_edit borderradius5\"><span>Editar</span></a></td>";
            echo "<td style=\"padding: 0; text-align: center;\"><a href=\"?pagina=deletar-usuario&id=".$usuario['id']."\" class=\"a_table_list a_del borderradius5\"><span>Excluir</span></a></td>";
            echo '</tr>';
            $i++;
        endforeach;
        ?>

    </table><!--/list_table-->
</section><!--/table -->