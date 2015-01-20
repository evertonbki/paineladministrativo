<?php 
    define(USER,'root');
    define(PASS,'');
    define(BANCO,'paineladministrativo');
    define(HOST,'localhost');
    
    $conecta = mysql_connect(HOST,USER,PASS) or die(mysql_error("O sistema enfrenta dificuldade, entre em contato com seu programador."));
    $conecta_banco = mysql_select_db(BANCO);
?>