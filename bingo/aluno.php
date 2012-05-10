<?php

require_once 'HTML/Table.php';
require_once 'functions.php';

//definindo variáveis
foreach ($_GET as $k=>$v) {
	$$k = $v;
}

if($id) {
	//pega a tabela do jogo
	$content = 'bingo.php';
} else {
	//lista os jogos disponíveis
	$content =  'cartela.php';
}

//debugando
include 'debug.php';

?>

<!DOCTYPE HTML>
<html lang="pt">
<head>
	<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
	<link href="../style.css" media="screen" type="text/css" rel="stylesheet" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js" type="text/javascript"></script>
</head>

<body>

<? include 'header.php'; ?>
<? include $content; ?>
<? echo $footer; ?>


</body>
</html> 

<?php

//primeiro passo, se não tiver cartela, disponibiliza a criação de uma
if(!$_GET['cartela']) {

$out = "";

}



?>
