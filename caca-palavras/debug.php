<?php
if($debug) {
	$debug_print = "<pre>";
	$debug_print .= "RESPOSTAS";
	$debug_print .= print_r($respostas);
	$debug_print .= "CRUZ";
	$debug_print .= print_r($cruz);
	$debug_print .= "MATRIZ";
	$debug_print .= print_r($matriz);
	$debug_print .= "LISTA";
	$debug_print .= print_r($lista);
	$debug_print .= "_GET";
	$debug_print .= print_r($_GET);
	$debug_print .= "</pre>";
}
?>
