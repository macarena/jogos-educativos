<?php

//definido tamanho padrão caso ele não seja defindo pela URL ou Bando de Dados
if(!$tam_x or !$tam_y) {
	$tam_x = 20;
	$tam_y = 20;
}

//preenchendo a tabela com palavras
$lista = array("ARARA","MARCO","INDIRA","AMOR","TESTE","CELULAR","ANIMAIS","SEXTA");

//coloca as palavras na tabela, se não conseguir, morre.
$max = 0;
while (!$test_ok) {
	$montagem = montaPalavras($tam_x,$tam_y,$lista);
	if($montagem !== false) { $test_ok = true ; }
	if($max == 100000) { die("Não foi possível gerar estas palavras com esse tamanho de grade"); }
	$max++;
}

$matriz = $montagem[0];
$respostas = $montagem[1];

$matriz = populaMatriz($tam_x,$tam_y,$matriz);

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
      $tabela->setCellAttributes($x, $y, "id=l-$y-$x");
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

<script>
(function ($) {

    var data = {"words": [
		<?php echo $respostas; ?>
		]}

    var $table = $('#board-game table');
    var $tds = $table.find('tbody tr td');

    var startPos = {x:0, y:0}
    var endPos = {x:0, y:0}
    var hits = 0;

    var holding = false;

	function getXY(q) {
		var temp = q.attr('id').split('-');
		return {x: parseInt(temp[2]), y: parseInt(temp[1])}
	} 


    function normalize_pos(start, end) {
        var delta = Math.max(Math.abs(end.x - start.x), Math.abs(end.y - start.y));
        if (start.x == end.x || start.y == end.y) {
            // empty
        } else if ( end.x > start.x && end.y < start.y ) { // nordeste
            end.y = start.y - delta;
            end.x = start.x + delta;
        } else if ( end.x > start.x && end.y > start.y ) { // sudeste
            end.y = start.y + delta;
            end.x = start.x + delta;
        } else if ( end.x < start.x && end.y > start.y ) { // sudoeste
            end.y = start.y + delta;
            end.x = start.x - delta;
        } else if ( end.x < start.x && end.y < start.y ) { // noroeste
            end.y = start.y - delta;
            end.x = start.x - delta;
        }
    }

    function valid_word(start, end) {
		for (var i = 0; i < data.words.length; i++) {
			var word = data.words[i];
			
            if ( word.x1 == start.x && word.y1 == start.y && word.x2 == end.x && word.y2 == end.y )
                return i;
            if ( word.x1 == end.x && word.y1 == end.y && word.x2 == start.x && word.y2 == start.y )
                return i;
        }
        return false;
    }

    function validate_answer(start, end) {
        
        normalize_pos(start, end);

        var id = valid_word(start, end);

        if ( id !== false ) {

            var word = data.words[id];

            word.x1 = word.x2 = word.y1 = word.y2 = -1;
            
            jQuery_sequence(word.pos).addClass('encontrado');

            $('#palavra-' + word.slug).addClass('acerto');
            
            if ( ++hits == data.words.length )
                alert('Parabéns! Você encontrou todas as respostas.');
        }
    }

    function highlight(start, end) {
        normalize_pos(start, end);
        var seq = create_sequence(start.x, start.y, end.x, end.y);
        jQuery_sequence(seq).addClass('marcado')
    }

    function unhighlight() {
        $tds.filter('.marcado').removeClass('marcado')
    }

	$table.bind('selectstart', function() {
		return false;
	}).css({ 'MozUserSelect' : 'none' });

    $tds.bind('mousedown', function() {
		
		if ( holding ) return;
		
		holding = true;
		
		var pos = getXY($(this));
		startPos.x = endPos.x = pos.x;
		startPos.y = endPos.y = pos.y;

	});

    $table.bind('mouseup', function() {
        holding = false;
        unhighlight();

        validate_answer(startPos, endPos);
    });

    $tds.hover(function() {
        if (!holding) return;

		var pos = getXY($(this));

		endPos.x = pos.x;
		endPos.y = pos.y;

        unhighlight();
        highlight(startPos, endPos);

    }, function () {

    });

	function create_sequence(x1, y1, x2, y2) {
		var seq = [];
		
		var ix = 0, iy = 0;
		
		if ( x1 != x2 )
			ix = (x2 - x1) / Math.abs(x2 - x1);
		
		if ( y1 != y2 )
			iy = (y2 - y1) / Math.abs(y2 - y1);
		
		tx = x1;
		ty = y1;
		
		seq.push([tx, ty])
		
		while ( ! (tx == x2 && ty == y2) ) {
			
			tx += ix;
			ty += iy;
			seq.push([tx, ty]);
			
		}
		
		return seq;
		
	}

	function jQuery_sequence(seq) {
		var ids = [];
		jQuery.each(seq, function(i, v) {
			x = v[0];
			y = v[1];
			ids.push("#l-" + y + "-" + x );
		});

		return jQuery(ids.join(', '));
	}

})(jQuery);
</script>
