<?php
include 'config.php';
include 'lesdb.php';
?>
<html>
<head>
	<meta charset="UTF-8">
	<title>
		Forslag p&aring; <?php echo $tittel; ?>
	</title>
	<meta name="viewport" content="width=device-width" />
	<link rel="stylesheet" type="text/css" href="standard.css" />
	<style>
	</style>
</head>
<body>
<script type="text/javascript">
<!--
    function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
    }
//-->
</script>
	<div id="header">
		<h1 onclick="toggle_visibility('avgrensboks');"<?php if ($_GET["submit"] === TRUE) { echo ' style="display:block;"';} ?>>Avgrens s&oslash;ket:</h1>
	</div>
	<div id="avgrensboks">
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?submit=TRUE" method="post">
			<label for="fid">Forslagsnummer: </label><br />
				<input type="text" id="fid" value="<?php echo $bare_fid;?>" name="fid" size="25" /><br />
			<?php
			if ($saksliste_brukes === TRUE) {
				echo '
					<label for="fsak">Saksnummer: (f.eks. 23/15a)</label><br />
				';
				if (!empty ($bare_fsak)){
				echo "<em>Viser nå sak $bare_fsak</em><br/>";
				}
				echo '
						<input list="fsak" name="fsak">
						<!--[if IE]><select disabled style="display:none"><![endif]-->
							<datalist name="fsak" id="fsak">
								' .  $saksliste . '
							</datalist>
							<!--[if IE]></select><![endif]-->
						</input><br />
				';
			}
			else {
				echo '
					<label for="fsak">Saksnummer: (f.eks. 23/15a)</label><br />
					<input type="text" id="fsak" value="';
				echo $bare_fsak;
				echo '" name="fsak" maxlength="6" size="6" /><br />
				';
			}
			?>
			<label for="fdelegat">Delegatnummer: </label><br />
				<input type="number" id="fdelegat" value="<?php echo $bare_fdelegat;?>" name="fdelegat" maxlength="6" size="6" /><br />
			<label for="etter">Sortert på: </label><br />
				<input type="radio" class="radio" id="etter" name="etter" value="id" <?php if (!empty ($bare_id)) { echo "checked";}?>>Nummer</input><br />
				<input type="radio" class="radio" id="etter" name="etter" value="Sak" <?php if (!empty ($bare_sak)) { echo "checked";}?>>Sak</input><br />
				<input type="radio" class="radio" id="etter" name="etter" value="Delegat" <?php if (!empty ($bare_delegat)) { echo "checked";}?>>Delegat</input><br />
			<label for="sortert">Sortert: </label><br />
				<input type="radio" class="radio" id="sortert" name="sortert" value="asc" <?php if (!empty ($asc)) { echo "checked";}?>>Stigende</input><br />
				<input type="radio" class="radio" id="sortert" name="sortert" value="desc" <?php if (!empty ($desc)) { echo "checked";}?>>Synkende</input><br />
			<input type="submit" class="button" value="Søk" />
			<input type="reset" class="button" value="Tilbakestill" />
		</form>
	</div>
	<div id="forslagsboks">
		<?php
		//Skriv svar på resultat - fyll ut viss feil eller tomt, sendt elles.
			if (!empty($resultat)) {
				echo "<p class='$resultattype'>$resultat<br/>$dbtilkopling_status</p>";
			}
			else {
			}
		?>
	<h2>Innkomne digitale forslag</h2><br/>
	<p>
		<em><a href="/">Send inn forslag her.</a><br/></em><br/>
		<em><a href="statistikk.php">Se statistikk på innkomne forslag.</a><br/></em>
	</p>
		<?php
			echo $forslagene;
			// Feilsøke
			// echo "$resultat $sakErr $linjeErr $delegatErr $namnErr $epostErr $typeErr $captchaErr $forslagErr";
		?>
	</div>
</body>
</html>