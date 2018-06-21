<?php
require('header.php');

$final = true;
$s = $st;
$des = true;
$detail=true;
if($_GET["p"] == "0") $ver = false;
else if($_GET["p"] == "2") $detail=false;
else {
  $ver = true;
  $des = false;
}
if(isset($_GET["hor"])) $hor = $_GET["hor"];
else $hor = -1;

if ($s["currenttime"] >= $s["sitelastmilescore"] && $ver) {
	$togo = (int) (($s['siteduration'] - $s["sitelastmilescore"])/60);
	echo"<br /><center><h2>Scoreboard (as of $togo minutes to go)</h2></center>\n";
} else
	echo"<br /><center><h2>Final Scoreboard</h2></center>\n";

require("$locr/scoretable.php");
include("$locr/footnote.php");
?>
