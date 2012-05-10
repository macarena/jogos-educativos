<?php

function gerarCartelas($nome,$n_min,$n_max) {
	if (!$nome) $nome = "Sem nome";

	//$n é o número min ou máximo
	if (!$n_min) $n_min = 1;
	if (!$n_max) $n_max = 100;

	//verifica se é possível gerar números não repetidos
	if ($n_max - $n_min < 25) return "impossível gerar cartela";

	//gerar 25 números randômicos
	$list_num = array();
	for ($i = 1; $i <= 25; ) {
		//não pode repetir
		$rand = mt_rand($n_min,$n_max);
		if (!in_array($rand, $list_num)) {
			$list_num[] = $rand;
			$i = $i+1;
		}
	}

	sort($list_num);
	$list_num = implode(',',$list_num);

	//gravando cartela no banco
	$insert = mysql_query("INSERT INTO cartelas (nome, numeros) VALUES ('$nome', '$list_num')");
	if (!$insert) {
		return "Não foi possível inserir a cartela no banco de dados: " . mysql_error();
	} else {
		return "Tabela gerada com sucesso";
	}
}

function sorteio($min, $max, $oper) {
	//por enquanto, não se não definirmos o operador, ele será uma adição
	if (!$oper) $oper = 'adicao';

	if ($oper == 'adicao') {
		$rand = mt_rand($min, $max);
		$x = mt_rand($min, $rand);
		$y = $rand - $x;
		$op = "$x + $y" ;
		$exp = "$op = $rand" ;
	}

	//colocando o sorteio no banco (somente o resultado, uma vez que os
	$insert = mysql_query("INSERT INTO sorteio (resultado, operacao) VALUES ($rand, '$op')");
	if (!$insert) {
		return "Não foi fazer o sorteio no banco de dados: " . mysql_error();
	}

	return $exp;
}

function listarSorteios() {

	$out = "<p>";
	$query = mysql_query("SELECT * FROM sorteio");

	while ($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
		$out .= "$row[operacao] = $row[resultado]</br>";
	}
	$out .= "</p>";

	return $out;
}

function desenhaCartela($nome, $marca) {
	//$nome --- nome da cartela
	//$marca --- true or false

	if(!$nome) return "Impossível desenhar a Cartela sem um nome.";
	if($marca) {
		$query = mysql_query("SELECT resultado FROM sorteio");
		while ($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
			$resultado[] = $row[resultado];
		}
	}

	$query = mysql_query("SELECT numeros FROM cartelas WHERE nome LIKE '$nome'");

	while ($row = mysql_fetch_array($query, MYSQL_ASSOC)) {
		$numeros = $row[numeros];
	}

	$out = '<p>';

	$numeros = explode(',',$numeros);
	$tabela = '<p>';

	$i = 1;
	foreach ($numeros as &$value) {

		if (in_array($value, $resultado)) $tabela .= "*";
		if ($i <= 5) $tabela .= "$value | ";
		if ($i == 5) { $tabela .= "</br>"; $i = 0; }
		$i++;	
	}

	$tabela .= '</p>';
	$out .= "$tabela </p>";

	return $out;
}
