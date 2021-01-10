<?php
header('Content-Type: application/xml; charset=utf-8');
session_start();
$phrase = $_SESSION['chaine'];
?>
<phrase><?php echo $phrase; ?></phrase>