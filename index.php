<?php
include 'config.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>
		Forslag til <?php echo $tittel; ?>
	</title>
	<meta name="viewport" content="width=device-width" />
	<link rel="stylesheet" type="text/css" href="standard.css" />
</head>

<body>
	<div id="skjema">
		<h1>Forslag til <?php echo $tittel; ?></h1>
		<?php
			//Skriv svar på resultat - fyll ut viss feil eller tomt, sendt elles.
			if (!empty ($resultat)) {
				echo "<p class='$resultattype'>$resultat<br/>$dbtilkopling_status</p>";
			}
		?>
		<p>
			<em><a href="forslag.php">Se innkomne digitale forslag her.</a></em><br/>
			<em><a href="statistikk.php">Se statistikk på innkomne forslag.</a><br/></em>
		</p>
		<p class="error">* obligatorisk felt.</p>
		<form action="?sendt=TRUE" method="post" accept-charset="utf-8">
			<?php
			if ($saksliste_brukes === TRUE) {
				echo '
					<label for="sak">Saksnummer: (f.eks. 23/15a)</label> ' . $sakvalt . '<span class="error">* <?php echo $sakErr;?></span><br />
						<input list="sak" name="sak">
						<!--[if IE]><select disabled style="display:none"><![endif]-->
							<datalist name="sak" id="sak">
								' .  $saksliste . '
							</datalist>
							<!--[if IE]></select><![endif]-->
						</input><br />
				';
			}
			else {
				echo '
					<label for="sak">Saksnummer: (f.eks. 23/15a)</label> <span class="error">* <?php echo $sakErr;?></span><br />
					<input type="text" id="sak" value="';
				echo $sak;
				echo '" name="sak" maxlength="6" size="6" /><br />
				';
			}
			?>
			<label for="linje">Linjenummer: </label> <span class="error">* <?php echo $linjeErr;?></span><br />
				<input type="text" id="linje" value="<?php echo $linje;?>" name="linje" min="1" maxlength="6" required size="6" /><br />
			<label for="delegat">Delegatnummer: </label> <span class="error">* <?php echo $delegatErr;?></span><br />
				<input type="number" id="delegat" value="<?php echo $delegat;?>" name="delegat" min="1" maxlength="6" required size="6" /><br />
			<label for="namn">Navn forslagsstiller: </label> <span class="error">* <?php echo $namnErr;?></span><br />
				<input type="text" id="namn" value="<?php echo $namn;?>" name="namn" required size="25" /><br />
			<label for="epost">E-post: </label> <span class="error">* <?php echo $epostErr;?></span><br />
				<input type="text" id="epost" value="<?php echo $epost;?>" name="epost" required size="25" /><br />
			<label for="type">Forslagstype: </label> <span class="error">* <?php echo $typeErr;?></span><br />
				<input type="radio" class="radio" id="type" name="type" value="Endring" <?php if (!empty ($_POST["Endring"])) { echo "checked";}?>>Endring</input><br />
				<input type="radio" class="radio" id="type" name="type" value="Tillegg" <?php if (!empty ($_POST["Tillegg"])) { echo "checked";}?>>Tillegg</input><br />
				<input type="radio" class="radio" id="type" name="type" value="Strykning" <?php if (!empty ($_POST["Strykning"])) { echo "checked";}?>>Strykning</input><br />
			<label for="forslag">Forslagstekst: </label> <span class="error">* <?php echo $forslagErr;?></span><br />
				<textarea id="forslag" name="forslag" required><?php echo $forslag;?></textarea><br />
			<label for="kommentar">Kommentar/begrunnelse: </label><br />
				<textarea id="kommentar" name="kommentar"><?php echo $kommentar;?></textarea><br />
			<label for="captcha">Passord? </label> <span class="error">* <?php echo $captchaErr;?></span><br />
				<input type="password" id="captcha" value="<?php echo $captcha;?>" name="captcha" required size="25" /><br /><br />
			<input type="submit" class="button" value="Send forslag" />
			<input type="reset" class="button" value="Tilbakestill" />
		</form>
	</div>
</body>

</html>