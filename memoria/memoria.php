<?

$imagen_formato=($_GET['formato']) ? $_GET['formato'] : 'png'; // Case sensitive
$grupo=$_GET['grupo'];

$imagenes[0]='01';
$imagenes[1]='02';
$imagenes[2]='03';
$imagenes[3]='04';
$imagenes[4]='05';
$imagenes[5]='06';
$imagenes[6]='07';
$imagenes[7]='08';
$imagenes[8]='09';
$imagenes[9]='10';
$imagenes[10]='11';
$imagenes[11]='12';
$imagenes[12]='13';
$imagenes[13]='14';
$imagenes[14]='15';
$imagenes[15]='16';

if ($grupo != "amarelo" AND $grupo != "vermelho") {
$imagenes[16]='17';
if ($grupo != "azul" AND $grupo != "verde") {
$imagenes[17]='18';
if ($grupo != "laranja") {
$imagenes[18]='19';
if ($grupo != "roxo") {
$imagenes[19]='20';
$imagenes[20]='21';
$imagenes[21]='22';
}}}}

$imagenes2=$imagenes;
$imagenes= array_merge($imagenes, $imagenes2);
shuffle($imagenes);
$n = count($imagenes);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Jogo da Memória</title>
<link rel="stylesheet" type="text/css" media="all" href="css/memotest.css">
<link rel="stylesheet" href="js/themes/light/light.modal.css" type="text/css" media="screen" title="light" />
<script src="js/jquery-1.2.3.pack.js" type="text/javascript"></script>
<script src="js/jquery-1.2.4b.js" type="text/javascript"></script>
<script src="js/jquery.timer.js" type="text/javascript"></script>
<script src="js/ui.core.js" type="text/javascript"></script>
<script src="js/ui.dialog.js" type="text/javascript"></script>
<script src="js/jqModal.js" type="text/javascript"></script>

<script type="text/javascript">


	$(window).ready(function(){



		function memotest(i, imagen){ 

			if( $(".s-"+imagen).hasClass('seleccionada')){
				// Si ya hay una imagen del par ya seleccionada (o sea, elige la 2da correctamente)
				$(".c-"+imagen).removeClass("abierto"); // Quitamos el cover del Bg, para mostrar la ficha
				$(".s-"+imagen).addClass("encontrada"); // se marca el div de la ficha como encontrada
				$(".c-"+imagen).addClass("trabado"); 
				var w = $(".encontrada");

				// Congratulation message / Mensaje de felicitacion.
				if(w.length == <?=$n?>){
					$.timer(300, function (timer) {					
					    $("#win").jqm().jqmShow();	
					    timer.stop();
					});
				}
			}else if( $(".ficha-cover").hasClass("abierto") ){
				// Si no hay coincidencia, y hay alguna abierta:
				$("#s-"+i).addClass("seleccionada"); // for the record... / lo grabamos.
				$("#c-"+i).addClass("abierto"); // display:none;

				// if no coincidence, hide items after 400ms / Si no acierta, espera 400ms para ocultar la ficha
				$.timer(1000, function (timer) {				
						
					$(".ficha").removeClass("seleccionada"); // not selected anymore / ya no esta seleccionada.
					$(".ficha-cover").removeClass("abierto"); // chau display:none;
						
				    timer.stop();
				});
			}else{
				// Si elige la primer ficha (de dos)
				$("#s-"+i).addClass("seleccionada"); // for the record... / lo grabamos.
				$("#c-"+i).addClass("abierto"); // display:none;
			}
		 }
		// Assign onClick to items / Asigna onClick a las fichas ('.ficha-cover').
		<? foreach($imagenes as $i => $imagen){	?>
		$("#c-<?=$i?>").click( function(){ memotest('<?=$i?>', '<?=$imagen?>');});
		<? }?>
	});

</script>
<style type="text/css">

<? 
$class_img=array();
foreach($imagenes as $i => $imagen){ 
	if(!in_array($imagen, $class_img)){
	$class_img[]=$imagen;
?>
.s-<?=$imagen?> {
	background-image:url(img/<?=$grupo?>/<?=$imagen?>.<?=$imagen_formato?>);
}
<? 
	}
}


if(empty($grupo)) {

?>
.ficha{
	height:64px;
}
.ficha-cover{
	height:64px;
}

<?

}

?>

</style>

</head>

<body>

<div align="center">

<div class="memotest" style="width:600px;">
<h1>Jogo da Memória</h1>

    <div style="margin-top:5px; height:262px;">
		<? foreach($imagenes as $i => $imagen){ ?>
		<div class="ficha s-<?=$imagen?>" id="s-<?=$i?>"><div class="ficha-cover c-<?=$imagen?>" id="c-<?=$i?>">&nbsp;</div>
		</div>
		<? }?>
    </div>

</div>
</div>


<div class="jqmWindow jqmClose" id="win">
<center>
<img src="img/parabens.jpg" border="0" style="margin:5px;" /> <br />
<b>Parabéns!</b> <br />
<a href="<?=$_SERVER[REQUEST_URI]?>" target="_self" title="Jogar novamente?">Jogar novamente?</a>
<center>
</div>

</body>
</html>
