<h1>Bingo Aritmético</h1>

<?php

//conectando mysql
require_once('db.php');
require_once('functions.php');

//echo '<pre>';
$a = sorteio(1,100);
//print_r ($a);

echo '<p>';

echo listarSorteios();
echo desenhaCartela('marco', true);

echo '</p>';

echo $out;

?>


