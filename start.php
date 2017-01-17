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
	<script src="standard.js"></script>
</head>

<body>
<?php
if ($forslag_dbtabell_oppretta == TRUE) {
	echo "Alt klart her!";
}
elseif ($_post["pass"] == $forslag_passord) {
	include 'lagdb.php';
	echo $forslag_dbtilkopling_status;
	echo "<br/>Oppdater variablene, og ta så i bruk skjemaet."
}
else {
	echo "Skriv inn passordet:<br/><form action='?' method='post' accept-charset='utf-8'><input type='password' name='pass' /><br/><input type='submit' class='button' value='Start' /></form>";
}
?>
</body>
</html>