<?php

// Kople til databasen
$forslag_dbtilkopling = new mysqli($forslag_dbserver, $forslag_dbbrukar, $forslag_dbpassord, $forslag_dbnamn);
// Sjekke tilkopling til databasen
if ($forslag_dbtilkopling->connect_errno) {
    die("Tilkopling feilet: " . $forslag_dbtilkopling->connect_errno . $forslag_dbtilkopling->connect_error);
} 

// Lese frå database
$forslag_lese_forslag ="SELECT id, Sak, Delegat, Namn, Epost, Linje, Type, Forslag, Kommentar FROM " . $forslag_dbtabell;

// Søke og kontrollere kva som visast
if (!empty ($forslag_dbid)) {
	$forslag_bare_fid = $forslag_dbid;
	$forslag_lese_forslag .= " WHERE id =" . $forslag_bare_fid;
}
elseif (!empty ($_POST['fid'])) {
	$forslag_bare_fid = test_input ($_POST['fid']);
	$forslag_lese_forslag .= " WHERE id =" . $forslag_bare_fid;
}
elseif (!empty ($_GET['fid'])) {
	$forslag_bare_fid = test_input ($_GET['fid']);
	$forslag_lese_forslag .= " WHERE id =" . $forslag_bare_fid;
}
elseif (!empty ($_GET['id'])) {
	$forslag_bare_id = test_input ($_GET['id']);
	$forslag_lese_forslag .= " WHERE id =" . $forslag_bare_id;
}
if (!empty ($_GET['fsak'])) {
	$forslag_bare_fsak = test_input($_GET['fsak']);
	$forslag_lese_forslag .= " WHERE Sak LIKE '" . $forslag_bare_fsak . "%'";
}
if (!empty ($_GET['fdelegat'])) {
	$forslag_bare_fdelegat = test_input ($_GET['fdelegat']);
	$forslag_lese_forslag .= " WHERE Delegat =" . $forslag_bare_fdelegat;
}
if (preg_match("/id/i",$_GET['etter'])) {
	$forslag_lese_forslag .= " ORDER BY id";
	$forslag_etter = test_input($_GET['etter']);
} 
if (preg_match("/Sak/i",$_GET['etter'])) {
	$forslag_lese_forslag .= " ORDER BY Sak";
	$forslag_etter = test_input($_GET['etter']);
}
if (preg_match("/Linje/i",$_GET['etter'])) {
	$forslag_lese_forslag .= " ORDER BY Linje";
	$forslag_etter = test_input($_GET['etter']);
}
if (preg_match("/Delegat/i",$_GET['etter'])) {
	$forslag_lese_forslag .= " ORDER BY Delegat";
	$forslag_etter = test_input($_GET['etter']);
}
if (!$forslag_etter) {
	$forslag_lese_forslag .= " ORDER BY id";
	$forslag_etter = test_input($_POST['etter']);
} 
if ($_POST['sortert'] == 'desc') {
	$forslag_lese_forslag .= " DESC";
	$forslag_sortert = test_input($_POST['sortert']);
}
elseif ($_GET['sortert'] == 'desc') {
	$forslag_lese_forslag .= " DESC";
	$forslag_sortert = test_input($_GET['sortert']);
}

$forslag_result = $forslag_dbtilkopling->query($forslag_lese_forslag);

if ($forslag_result->num_rows > 0) {
	$forslag_forslagene_tal = $forslag_result->num_rows;
    $forslag_forslagene = "
		<table>
			<tr>
				<th>Nr:</th>
				<th>Sak:</th>
				<th>Delegat:</th>
				<th>Navn:</th>
				<th>Linje:</th>
				<th>Type:</th>
				<th>Forslag:</th>
				<th>Kommentar:</th>
			</tr>
		";
    // output data of each row
    while($forslag_row = mysqli_fetch_assoc($forslag_result)) {
		// Ordne formattering for forslag/kommentarer
		$forslag_row['Forslag'] = allow_formatting($forslag_row['Forslag']);
		$forslag_row['Kommentar'] = allow_formatting($forslag_row['Kommentar']);
        $forslag_forslagene .= "
		<tr>
			<td><a href='" . $forslag_baseurl . "/forslag.php?id=" . $forslag_row['id'] . "'>" . $forslag_row['id'] . "</a></td>
			<td><a href='" . $forslag_baseurl . "/forslag.php?fsak=" . $forslag_row['Sak'] . "'>"  . $forslag_row['Sak'] . "</a></td>
			<td><a href='" . $forslag_baseurl . "/forslag.php?fdelegat=" . $forslag_row['Delegat'] . "'>"  . $forslag_row['Delegat'] . "</a></td>
			<td><a href='mailto:" . $forslag_row['Epost'] . "'>".$forslag_row['Namn']."</a></td>
			<td>".$forslag_row['Linje']."</td>
			<td>".$forslag_row['Type']."</td>
			<td class='brei-f'>".$forslag_row['Forslag']."</td>
			<td class='brei-k'>".$forslag_row['Kommentar']."</td>
		</tr>
		";
    }
    $forslag_forslagene .= "</table>";
} else {
    $forslag_forslagene = "Ingen forslag";
}

/* change character set to utf8 */
/*
if (!mysqli_set_charset($forslag_dbtilkopling, "utf8")) {
    $forslag_forslagene .= "Error loading character set utf8: %s\n" . mysqli_error($forslag_dbtilkopling);
} else {
    $forslag_forslagene .= "Current character set: %s\n", mysqli_character_set_name($forslag_dbtilkopling);
}
*/

// Feilsøking: Vis kva det sorteres etter, og kva spørringa var.
/*
	$forslag_variablar = "id=" . $_POST['id'] . ". ";
	$forslag_variablar .= "Sak=" . $_POST['Sak'] . ". ";
	$forslag_variablar .= "Delegat=" . $_POST['Delegat'] . ". ";
	$forslag_variablar .= "etter=" . $_POST['etter'] . ". ";
	$forslag_variablar .= "sortert=" . $_POST['sortert'] . ". ";
	$forslag_variablar = test_input($forslag_variablar);
	$forslag_resultat .= "<p>Spørring: " . $forslag_lese_forslag . "<br/>Variablar: " . $forslag_variablar . "</p>";
*/
	
$forslag_dbtilkopling->close();

?>