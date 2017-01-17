<?php
include 'config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>
		Forslag til <?php echo $forslag_tittel; ?>
	</title>
	<meta name="viewport" content="width=device-width" />
	<link rel="stylesheet" type="text/css" href="standard.css" />
	<script src="standard.js"></script>
</head>

<body>
	<div id="skjema">
		<h1>Forslag til <?php echo $forslag_tittel; ?></h1>
		<?php
			//Skriv svar på resultat - fyll ut viss feil eller tomt, sendt elles.
			if (!empty ($forslag_resultat)) {
				echo "<p class='$forslag_resultattype'>$forslag_resultat<br/>$forslag_dbtilkopling_status</p>";
			}
		?>
		<p>
			<em><a href="forslag.php">Se innkomne digitale forslag her.</a></em><br/>
			<em><a href="statistikk.php">Se statistikk på innkomne forslag.</a><br/></em>
		</p>
		<p class="error">* obligatorisk felt.</p>
		<form action="?sendt=TRUE" method="post" accept-charset="utf-8">
			<?php
			if ($forslag_saksliste_brukes === TRUE) {
				echo '
					<label for="sak">Saksnummer: (f.eks. 23/15a)</label> ' . $forslag_sakvalt . '<span class="error">* <?php echo $forslag_skjemaErr["sak"];?></span><br />
						<input list="sak" name="sak">
						<!--[if IE]><select disabled style="display:none"><![endif]-->
							<datalist name="sak" id="sak">
								' .  $forslag_saksliste . '
							</datalist>
							<!--[if IE]></select><![endif]-->
						</input><br />
				';
			}
			else {
				echo '
					<label for="sak">Saksnummer: (f.eks. 23/15a)</label> <span class="error">* <?php echo $forslag_skjemaErr["sak"];?></span><br />
					<input type="text" id="sak" value="';
				echo $forslag_sak;
				echo '" name="sak" maxlength="6" size="6" /><br />
				';
			}
			?>
			<label for="linje">Linjenummer: </label> <span class="error">* <?php echo $forslag_skjemaErr["linje"];?></span><br />
				<input type="text" id="linje" value="<?php echo $forslag_linje;?>" name="linje" min="1" maxlength="6" required size="6" /><br />
			<label for="delegat">Delegatnummer: </label> <span class="error">* <?php echo $forslag_skjemaErr["delegat"];?></span><br />
				<input type="number" id="delegat" value="<?php echo $forslag_delegat;?>" name="delegat" min="1" maxlength="6" required size="6" /><br />
			<label for="namn">Navn forslagsstiller: </label> <span class="error">* <?php echo $forslag_skjemaErr["namn"];?></span><br />
				<input type="text" id="namn" value="<?php echo $forslag_namn;?>" name="namn" required size="25" /><br />
			<label for="epost">E-post: </label> <span class="error">* <?php echo $forslag_skjemaErr["epost"];?></span><br />
				<input type="text" id="epost" value="<?php echo $forslag_epost;?>" name="epost" required size="25" /><br />
			<label for="type">Forslagstype: </label> <span class="error">* <?php echo $forslag_skjemaErr["type"];?></span><br />
				<input type="radio" class="radio" id="type" name="type" value="Endring" <?php if (!empty ($_POST["Endring"])) { echo "checked";}?>>Endring</input><br />
				<input type="radio" class="radio" id="type" name="type" value="Tillegg" <?php if (!empty ($_POST["Tillegg"])) { echo "checked";}?>>Tillegg</input><br />
				<input type="radio" class="radio" id="type" name="type" value="Strykning" <?php if (!empty ($_POST["Strykning"])) { echo "checked";}?>>Strykning</input><br />
			<label for="forslag">Forslagstekst: </label> <span class="error">* <?php echo $forslag_skjemaErr["forslag"];?></span><br />
				<textarea id="forslag" name="forslag" required><?php echo $forslag_forslag;?></textarea><br />
			<label for="kommentar">Kommentar/begrunnelse: </label><br />
				<textarea id="kommentar" name="kommentar"><?php echo $forslag_kommentar;?></textarea><br />
			<label for="pass">Passord? </label> <span class="error">* <?php echo $forslag_skjemaErr["pass"];?></span><br />
				<input type="password" id="pass" value="<?php echo $forslag_pass;?>" name="pass" required size="25" /><br /><br />
			<input type="submit" class="button" value="Send forslag" />
			<input type="reset" class="button" value="Tilbakestill" />
		</form>
	</div>
</body>

</html>