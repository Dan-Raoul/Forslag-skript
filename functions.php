<?php
// Strippe input, for å sikre mot hacking
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlentities($data);
  $data = str_replace("\\", "&bsol;", $data);
  $data = str_replace("'", "&apos;", $data);
  $data = str_replace('"', "&quot;", $data);
  $data = str_replace("\n", '<br />', $data );
  $data = str_replace("æ", "&aelig;", $data);
  $data = str_replace("Æ", "&AElig;", $data);
  $data = str_replace("å", "&aring;", $data);
  $data = str_replace("Å", "&Aring;", $data);
  $data = str_replace("ø", "&oslash;", $data);
  $data = str_replace("Ø", "&Oslash;", $data);
  return $data;
};

// Endre tilbake formattering slik at det verkar - bare bruk ved visning - ikkje ved skrivning til DB!
function allow_formatting($data) {
	$data = str_replace("&lt;br /&gt;", "<br />", $data);
	$data = str_replace("&lt;br/&gt;", "<br />", $data);
	$data = str_replace("&lt;br&gt;", "<br />", $data);
	$search = array( 
                '/\[b\](.*?)\[\/b\]/is', 
                '/\[i\](.*?)\[\/i\]/is', 
                '/\[u\](.*?)\[\/u\]/is', 
                '/\&lt;b\&gt;(.*?)\&lt;\/b\&gt;/is', 
                '/\&lt;i\&gt;(.*?)\&lt;\/i\&gt;/is', 
                '/\&lt;u\&gt;(.*?)\&lt;\/u\&gt;/is', 
                '/\&lt;strong\&gt;(.*?)\&lt;\/strong\&gt;/is', 
                '/\&lt;em\&gt;(.*?)\&lt;\/em\&gt;/is', 
                '/\&lt;u\&gt;(.*?)\&lt;\/u\&gt;/is', 
                '/\&lt;p\&gt;(.*?)\&lt;\/p\&gt;/is', 
                ); 
	$replace = array( 
                '<strong>$1</strong>', 
                '<em>$1</em>', 
                '<u>$1</u>', 
                '<strong>$1</strong>', 
                '<em>$1</em>', 
                '<u>$1</u>', 
                '<strong>$1</strong>', 
                '<em>$1</em>', 
                '<u>$1</u>', 
                '<p>$1</p>', 
                );
	$data = preg_replace ($search, $replace, $data);
	return $data;
}

// Vidaresendingsfunksjon
function redirect($filename, $timer = NULL) {
	if (!$timer) {
		if (!headers_sent())
			header('Location: '.$filename);
		else {
			echo '<script type="text/javascript">';
			echo 'window.location.href="'.$filename.'";';
			echo '</script>';
			echo '<noscript>';
			echo '<meta http-equiv="refresh" content="0;url='.$filename.'" />';
			echo '</noscript>';
		}
	}
	else {
		if (!headers_sent())
			header('Refresh: '.$timer.'; URL='.$filename);
		else {
			echo '<script type="text/javascript">';
			echo 'window.location.href="'.$filename.'";';
			echo '</script>';
			echo '<noscript>';
			echo '<meta http-equiv="refresh" content="'.$timer.';url='.$filename.'" />';
			echo '</noscript>';
		}
	}
}

// Samle brukarinfo
// Først IP
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $forslag_ip = test_input($_SERVER['HTTP_CLIENT_IP']);
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $forslag_ip = test_input($_SERVER['HTTP_X_FORWARDED_FOR']);
} else {
    $forslag_ip = test_input($_SERVER['REMOTE_ADDR']);
};
// Nettlesar, kor dei kjem frå
$forslag_nettleser 		= 	test_input($_SERVER['HTTP_USER_AGENT']);
$forslag_referent		=	test_input($_SERVER['HTTP_REFERER']);

// Sette datetime for skriving til database
date_default_timezone_set('Europe/Oslo');
$forslag_tid				=	date('Y-m-d H:i:s');

// Sette opp PDO - kople til database
$forslag_pdo_dsn		=	"mysql:host=$forslag_dbserver;dbname=$forslag_dbnamn;charset=$forslag_dbteiknkoding";
$forslag_pdo_opt		=	[
    PDO::ATTR_ERRMODE            				=> 	PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE 		=> 	PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   			=> 	FALSE,
];

// Autoppdatering

if($_COOKIE[forslag_autorefresh_cookie] == 2) {
	$forslag_autorefresh = 2;
	$forslag_autorefresh_tekst = "Autoppdatering: PÅ";
	$forslag_autorefresh_change = 1;
}
else {
    $forslag_autorefresh = 1;
	$forslag_autorefresh_tekst = "Autoppdatering: AV";
	$forslag_autorefresh_change = 2;
}

?>