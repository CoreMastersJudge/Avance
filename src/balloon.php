<?php

ob_start();
header ("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header('Content-type: image/png');
ob_end_flush();

require_once('fballoon.php');

$get_s=false;
if(isset($_GET["s"]))
	$get_s=true;
$get_color=null;
if(isset($_GET["color"]))
	$get_color=$_GET["color"];

balloonpng($_SESSION["locr"],$get_s,$get_color,null);
?>
