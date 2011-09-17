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

		$respostas[$palavra][answer] = $palavra;
		$respostas[$palavra][backwards] = 'false';

		$respostas[$palavra][x1] = $px;
		$respostas[$palavra][y1] = $py;
		$respostas[$palavra][clue] = 'null';
		$respostas[$palavra][slug] = $palavra;
		for ($i = 0; $i < strlen($palavra); $i++) {
			if(empty($m[$px][$py]) or $m[$px][$py] == $palavra[$p]) {
				$m[$px][$py] = $palavra[$i];	
			} else { return false; }
			$respostas[$palavra][pos] .= ($i == 0) ? "[$px, $py]" : ", [$px, $py]";
			$respostas[$palavra][x2] = $px;
			$respostas[$palavra][y2] = $py;
			$px = ($dir <= 0) ? $px+1 : $px;
			$py = ($dir >= 0) ? $py+1 : $py;
		}
	}

	$out = '';
	$i = 0;

	foreach($respostas as $dados){
		$out .= ($i == 0) ? "{" : ",{";
		foreach($dados as $k=>$v){
			if($k == 'answer') { $out .= "\"$k\": \"$v\""; }
			elseif($k == 'slug') { $out .= ", \"$k\": \"$v\""; }
			elseif($k == 'pos') { $out .= ", \"$k\": [$v]"; }
			else { $out .= ", \"$k\": $v "; }
		}
		$out .= "}";
		$i++;
	}

	return array($m,$out);
}

?>
