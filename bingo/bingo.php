<?php

$tam_x = 5;
$tam_y = 5;

//preenchendo a tabela com palavras
$lista = array("ARARA","MARCO","INDIRA","AMOR","TESTE","CELULAR","ANIMAIS","SEXTA");

//coloca as palavras na tabela, se não conseguir, morre.
$max = 0;
while (!$test_ok) {
//	$montagem = montaPalavras($tam_x,$tam_y,$lista);
	if($montagem !== false) { $test_ok = true ; }
	if($max == 100000) { die("Não foi possível gerar estas palavras com esse tamanho de grade"); }
	$max++;
}

$matriz = $montagem[0];
$respostas = $montagem[1];

//$matriz = populaMatriz($tam_x,$tam_y,$matriz);

if($tam_x < 11) { 
	$tam_tabela = 'P';
} elseif($tam_x < 16) {
	$tam_tabela = 'M';
} else {
	$tam_tabela = 'G';
}

//desenhando a tabelas
$tabela = new HTML_Table("class=\"content tabela $tam_tabela\"");
$tabela->setAutoGrow(true);

for ($x = 0; $x < $tam_x; $x++) {
  for ($y = 0; $y < $tam_y; $y++) {
      $tabela->setCellContents($x, $y, $matriz[$x][$y]);
      $tabela->setCellAttributes($x, $y, "id=xy-$y-$x");
  }
}

//exibir as respostas == 
/*
if($exibirRespostas) {
	foreach($respostas as $palavra){
		foreach($palavra as $letra){
			$tabela->setCellAttributes($letra[x], $letra[y], 'class="selecionado"');
			if(in_array($letra[y], $cruz["$letra[x]"])) {
				$tabela->setCellAttributes($letra[x], $letra[y], 'class="selecionado cruz"');
			}
			$cruz["$letra[x]"][] = $letra[y];
			
		}
	}
}
*/
//exibindo a tabela
$content = $tabela->toHtml();
?>

<div class="main clearfix content">
	<div class="jogo-header">
		<h1 class="jogo-header">Nome do Jogo 1</h1>
		<h2 class="jogo-header">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam vitae enim sit amet nisl viverra aliquam et eu turpis. Sed leo augue, commodo ut volutpat vel, congue non felis. Duis vitae lectus ac tellus pharetra luctus nec et sapien. Pellentesque nec facilisis dui. Integer varius felis at enim posuere non sagittis diam sagittis. In fringilla rhoncus semper. Vivamus ultricies fringilla augue a scelerisque. Aliquam a fringilla justo.</h2>
	</div>
		<div id=board-game><? echo $content; ?></div>
</div>
