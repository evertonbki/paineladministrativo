<?php

/* * ***************************
  FUNÇÃO DE CADASTRO NO BANCO
 * *************************** */

function create($tabela, array $datas) {
    $fields = implode(", ", array_keys($datas));
    $values = "'" . implode("', '", array_values($datas)) . "'";
    $qrCreate = "INSERT INTO {$tabela} ($fields) VALUES ($values)";
    $stCreate = mysql_query($qrCreate) or die('Erro ao cadastrar em ' . $tabela . ' ' . mysql_error());

    if ($stCreate) {
        return true;
    }
}

/* * ***************************
  FUNÇÃO DE CADASTRO NO BANCO
 * *************************** */

function read($tabela, $cond = NULL) {
    $qrRead = "SELECT * FROM {$tabela} {$cond}";
    $stRead = mysql_query($qrRead) or die('Erro ao ler em ' . $tabela . ' ' . mysql_error());
    $cField = mysql_num_fields($stRead);
    for ($y = 0; $y < $cField; $y++) {
        $names[$y] = mysql_field_name($stRead, $y);
    }
    for ($x = 0; $res = mysql_fetch_assoc($stRead); $x++) {
        for ($i = 0; $i < $cField; $i++) {
            $resultado[$x][$names[$i]] = $res[$names[$i]];
        }
    }
    return $resultado;
}

/* * ***************************
  FUNÇÃO DE EDIÇÃO NO BANCO
 * *************************** */

function update($tabela, array $datas, $where) {
    foreach ($datas as $fields => $values) {
        $campos[] = "$fields = '$values'";
    }

    $campos = implode(", ", $campos);
    $qrUpdate = "UPDATE {$tabela} SET $campos WHERE {$where}";
    $stUpdate = mysql_query($qrUpdate) or die('Erro ao atualizar em ' . $tabela . ' ' . mysql_error());

    if ($stUpdate) {
        return true;
    }
}

/* * ***************************
  FUNÇÃO DE DELETAR NO BANCO
 * *************************** */

function delete($tabela, $where) {
    $qrDelete = "DELETE FROM {$tabela} WHERE {$where}";
    $stDelete = mysql_query($qrDelete) or die('Erro ao deletar em ' . $tabela . ' ' . mysql_error());
}

/* * ***************************
  UPLOAD DE IMAGENS
 * *************************** */

function uploadImg($tmp, $nome, $largura, $pasta) {

    $img = imagecreatefromjpeg($tmp);
    $x = imagesx($img);
    $y = imagesy($img);
    $altura = ($largura * $y) / $x;
    $nova = imagecreatetruecolor($largura, $altura);
    imagecopyresampled($nova, $img, 0, 0, 0, 0, $largura, $altura, $x, $y);
    imagejpeg($nova, "$pasta/$nome");
    imagedestroy($nova);
    imagedestroy($img);
    return($nome);
    return true;
}

function uploadImgPng($tmp, $nome, $largura, $pasta) {

    $img = imagecreatefrompng($tmp);
    $x = imagesx($img);
    $y = imagesy($img);
    $altura = ($largura * $y) / $x;
    $nova = imagecreatetruecolor($largura, $altura);
    imagecopyresampled($nova, $img, 0, 0, 0, 0, $largura, $altura, $x, $y);
    imagejpeg($nova, "$pasta/$nome");
    imagedestroy($nova);
    imagedestroy($img);
    return($nome);
    return true;
}

function valMail($email) {
    if (preg_match('/[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/', $email)) {
        return true;
    } else {
        return false;
    }
}

/* * ***************************
  TRANFORMA STRING EM URL
 * *************************** */

function setUri($string) {
    $a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
    $b = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';
    $string = utf8_decode($string);
    $string = strtr($string, utf8_decode($a), $b);
    $string = strip_tags(trim($string));
    $string = str_replace(" ", "-", $string);
    $string = str_replace(array("-----", "----", "---", "--"), "-", $string);
    return strtolower(utf8_encode($string));
}

/* * ***************************
  Paginação de resultados
 * *************************** */

function readPaginator($tabela, $cond, $maximos, $link, $pag, $width = NULL, $maxlinks = 4) {
    $readPaginator = read("$tabela", "$cond");
    $total = count($readPaginator);
    if ($total > $maximos) {
        $paginas = ceil($total / $maximos);
        if ($width) {
            echo '<div class="paginator" style="width:' . $width . '">';
        } else {
            echo '<div class="paginator">';
        }
        echo '<a href="' . $link . '1">Primeira Página</a>';
        for ($i = $pag - $maxlinks; $i <= $pag - 1; $i++) {
            if ($i >= 1) {
                echo '<a href="' . $link . $i . '">' . $i . '</a>';
            }
        }
        echo '<span class="atv">' . $pag . '</span>';
        for ($i = $pag + 1; $i <= $pag + $maxlinks; $i++) {
            if ($i <= $paginas) {
                echo '<a href="' . $link . $i . '">' . $i . '</a>';
            }
        }
        echo '<a href="' . $link . $paginas . '">Última Página</a>';
        echo '</div><!-- /paginator -->';
    }
}

/*****************************
FORMATA DATA EM TIMESTAMP
*****************************/	

	function formDate($data){
		$timestamp = explode(" ",$data);
		$getData = $timestamp[0];
		$getTime = $timestamp[1];
		
			$setData = explode('-',$getData);
			$dia = $setData[0];
			$mes = $setData[1];
			$ano = $setData[2];
			
		if(!$getTime):
			$getTime = date('H:i:s');
		endif;
			
		$resultado = $ano.'-'.$mes.'-'.$dia.' '.$getTime;
		
		return $resultado;
		
	}

?>