<?php

require_once 'HTML/Table.php';
require_once 'functions.php';

//definindo variáveis
foreach ($_GET as $k=>$v) {
	$$k = $v;
}

if($id) {
	//pega a tabela do jogo
	$content = 'tabela.php';
} else {
	//lista os jogos disponíveis
	$content =  'listagem.php';
}

//debugando
include 'debug.php';

?>

<!DOCTYPE HTML>
<html lang="pt">
<head>
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<link href="style.css" media="screen" type="text/css" rel="stylesheet" />
</head>

<body>

<? include 'header.php'; ?>
<? include $content; ?>
<? echo $footer; ?>

</body>
</html> 
