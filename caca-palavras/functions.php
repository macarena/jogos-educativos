<?php

//gerando uma letra aleatória
function pegaLetra() {
	$letras = strtoupper('abcdefghijklmnopqrstuvwxyz');
	$letra_rand = $letras[mt_rand(0, 25)];
	return $letra_rand;
}

//populando a matriz
function populaMatriz($matriz_x,$matriz_y,$matriz) {
	for ($x = 0; $x < $matriz_x; $x++) {
		for ($y = 0; $y < $matriz_y; $y++) {
			$matriz[$x][$y] = (empty($matriz[$x][$y])) ? pegaLetra() : $matriz[$x][$y];
		}
	}
	return $matriz;
}

function montaPalavras($matriz_x,$matriz_y,$lista) {
	$m = array();
	foreach($lista as $palavra) {
		//define direção -1-vertical 1-horizontal 0-diagonal
		$dir = mt_rand(-1,1);
		//$dir = 1;
		//define inicio da palavra
		$px = ($dir <= 0) ? mt_rand(0, $matriz_x - strlen($palavra)) : mt_rand(0, $matriz_x-1);
		$py = ($dir >= 0) ? mt_rand(0, $matriz_y - strlen($palavra)) : mt_rand(0, $matriz_y-1);

		for ($p = 0; $p < strlen($palavra); $p++) {
			if(empty($m[$px][$py]) or $m[$px][$py] == $palavra[$p]) {
				$m[$px][$py] = $palavra[$p];	
			} else { return false; }
			$respostas[$palavra][] = array('x'=>$px,'y'=>$py);
			$px = ($dir <= 0) ? $px+1 : $px;
			$py = ($dir >= 0) ? $py+1 : $py;
		}
	}
	return array($m,$respostas);
}

//exibir respostas
function exibirRespostas($respostas) {
	foreach($respostas as $palavra){
		foreach($palavra as $letra){
			$tabela->setCellAttributes($letra[x], $letra[y], "bgcolor=green align=center");
			if(in_array($letra[y], $cruz["$letra[x]"])) {
				$tabela->setCellAttributes($letra[x], $letra[y], "bgcolor=red align=center");
			}
			$cruz["$letra[x]"][] = $letra[y];
			
		}
	}
	return $tabela;
}

?>
