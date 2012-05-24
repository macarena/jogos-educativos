
<!DOCTYPE HTML>
<html>
<head>
</head>
<body>
<h1>Jogos Educativos</h1>

<?php
$arquivos = scandir('.');

foreach($arquivos as $dir) {
	if(is_dir($dir) and file_exists("$dir/info_je")) {
		
		echo "<a href='$dir/' >$dir</a>\n";
	}	
}

?>


</body>
<html>
