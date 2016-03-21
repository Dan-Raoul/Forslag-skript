<?php
include 'config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>
		Oppstart med forslag til <?php echo $forslag_tittel; ?>
	</title>
	<meta name="viewport" content="width=device-width" />
	<link rel="stylesheet" type="text/css" href="standard.css" />
</head>

<body>
<?php
if ($forslag_dbtabell_oppretta == TRUE) {
	echo "Alt klart her!";
}
elseif ($_GET["pass"] == $forslag_passord) {
	include 'lagdb.php';
	echo $forslag_dbtilkopling_status;
}
else {
	echo "Skriv inn passordet:<br/><form action='?' method='get' accept-charset='utf-8'><input type='password' name='pass' /><br/><input type='submit' class='button' value='Start' /></form>";
}
?>
</body>
</html>