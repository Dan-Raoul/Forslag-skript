<?php
include 'config.php';
include 'lesdb.php';
if ($forslag_forslagene_tal > 0) {
	$forslag_sidetittel = "($forslag_forslagene_tal) Forslag p&aring; $forslag_tittel";
}
elseif ($forslag_forslagene_tal = 0) {
	$forslag_sidetittel = "Forslag p&aring; $forslag_tittel";
}
else {
	$forslag_sidetittel = "Forslag p&aring; $forslag_tittel";
};
?>
<html>
<head>
	<meta charset="UTF-8">
	<title><?php echo $forslag_sidetittel; ?></title>
	<meta name="viewport" content="width=device-width" />
	<link rel="stylesheet" type="text/css" href="standard.css" />
	<script src="standard.js"></script>
	<?php 
		if($forslag_autorefresh == 2) {
			echo "<meta http-equiv='refresh' content='" . $forslag_autorefresh_sekunder . "' />";
		}
	?>
</head>
<body>
	<div id="header">
		<h1 onclick="toggle_visibility('avgrensboks');">Avgrens s&oslash;ket:</h1>
	</div>
	<div id="avgrensboks"<?php if ($_GET["submit"] == TRUE) { echo ' style="display:block;"';} ?>>
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>?submit=TRUE" method="get" id="avgrens">
			<label for="id">Forslagsnummer: </label><br />
				<input type="text" id="id" value="<?php echo $forslag_bare_id;?>" name="id" size="25" /><br />
			<?php
			if ($forslag_saksliste_brukes === TRUE) {
				echo '
					<label for="fsak">Saksnummer: (f.eks. 23/15a)</label><br />
				';
				if (!empty ($bare_fsak)){
				echo "<em>Viser nå sak $forslag_bare_fsak</em><br/>";
				}
				echo '
						<input list="fsak" name="fsak">
						<!--[if IE]><select disabled style="display:none"><![endif]-->
							<datalist name="fsak" id="fsak">
								' .  $forslag_saksliste . '
							</datalist>
							<!--[if IE]></select><![endif]-->
						</input><br />
				';
			}
			else {
				echo '
					<label for="fsak">Saksnummer: (f.eks. 23/15a)</label><br />
					<input type="text" id="fsak" value="';
				echo $forslag_bare_fsak;
				echo '" name="fsak" maxlength="6" size="6" /><br />
				';
			}
			?>
			<label for="fdelegat">Delegatnummer: </label><br />
				<input type="number" id="fdelegat" value="<?php echo $forslag_bare_fdelegat;?>" name="fdelegat" maxlength="6" size="6" /><br />
			<label for="etter">Sortert på: </label><br />
				<input type="radio" class="radio" id="etter" name="etter" value="id" <?php if (!$forslag_etter) { echo "checked";}?>>Nummer</input><br />
				<input type="radio" class="radio" id="etter" name="etter" value="Sak" <?php if (preg_match("/Sak/i",$forslag_etter)) { echo "checked";}?>>Sak</input><br />
				<input type="radio" class="radio" id="etter" name="etter" value="Linje" <?php if (preg_match("/Linje/i",$forslag_etter)) { echo "checked";}?>>Linjenummer/Kapittel/Avsnitt</input><br />
				<input type="radio" class="radio" id="etter" name="etter" value="Delegat" <?php if (preg_match("/Delegat/i",$forslag_etter)) { echo "checked";}?>>Delegat</input><br />
			<label for="sortert">Sortert: </label><br />
				<input type="radio" class="radio" id="sortert" name="sortert" value="asc" <?php if (!$forslag_sortert) { echo "checked";}?>>Stigende</input><br />
				<input type="radio" class="radio" id="sortert" name="sortert" value="desc" <?php if ($forslag_sortert) { echo "checked";}?>>Synkende</input><br />
			<input type="submit" class="button" value="Søk" />
			<input type="reset" class="button" value="Tilbakestill" onclick="return resetForm(this.form);" />
		</form>
	</div>
	<div id="forslagsboks">
		<?php
		//Skriv svar på resultat - fyll ut viss feil eller tomt, sendt elles.
			if (!empty($forslag_resultat)) {
				echo "<p class='$forslag_resultattype'>$forslag_resultat<br/>$forslag_dbtilkopling_status</p>";
			}
			else {
			}
		?>
	<h2>Innkomne digitale forslag</h2><br/>
	<p>
		<em><a href="<?php echo $forslag_baseurl; ?>">Send inn forslag her.</a></em><br/>
		<em><a href="statistikk.php">Se statistikk på innkomne forslag.</a><br/></em>
	</p>
	<p class="autorefresh">
		<a onclick="createAutoRefreshCookie('forslag_autorefresh_cookie','<?php echo $forslag_autorefresh_change; ?>','3','<?php echo $forslag_domene; ?>');">
			<?php
				echo $forslag_autorefresh_tekst;
			?>
		</a>
	</p>
		<?php
			echo $forslag_forslagene;
			// Feilsøke
			// echo "$forslag_resultat $forslag_sakErr $forslag_linjeErr $forslag_delegatErr $forslag_namnErr $forslag_epostErr $forslag_typeErr $forslag_passErr $forslag_forslagErr";
		?>
	</div>
</body>
</html>