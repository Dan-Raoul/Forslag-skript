<?php
// Strippe input, for å sikre mot hacking
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = str_replace("'", "&#39;", $data);
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

// Vidaresendingsfunksjon
function redirect($filename) {
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


?>