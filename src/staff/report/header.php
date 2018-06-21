<?php


ob_start();
header ("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-Type: text/html; charset=utf-8");
session_start();
ob_end_flush();
//$locr = $_SESSION['locr'];
//$loc = $_SESSION['loc'];
$loc = $locr = "../..";

require $locr.'/version.php';
require_once($locr . "/globals.php");
if(!ValidSession()) {
        InvalidSession($_SERVER['PHP_SELF']);
        ForceLoad($loc."/index.php");
}
if($_SESSION["usertable"]["usertype"] != "staff") {
        IntrusionNotify($_SERVER['PHP_SELF']);
        ForceLoad($loc."/index.php");
}

require_once($locr."/db.php");
require_once($locr."/freport.php");

echo "<html><head><title>Report Page</title>\n";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n";

echo "<link rel=stylesheet href=\"$loc/Css.php\" type=\"text/css\">\n";

$contest=$_SESSION["usertable"]["contestnumber"];
if(($ct = DBContestInfo($contest)) == null)
        ForceLoad($loc."/index.php");
$site=$_SESSION["usertable"]["usersitenumber"];
if(($st = DBSiteInfo($contest,$site)) == null)
        ForceLoad($loc."/index.php");

echo "</head><body><table border=1 width=\"100%\">\n";
echo "<tr><td bgcolor=\"eeee00\" nowrap align=center>";
echo "<img src=\"$loc/images/smallballoontransp.png\" alt=\"\">";
echo "<font color=\"#ffffff\"><a href=\"http://www.ime.usp.br/~cassio/boca/\">BOCA</a></font>";
echo "</td><td bgcolor=\"#eeee00\" width=\"99%\">\n";
echo $ct["contestname"] . " - " . $st["sitename"] . "</td>\n";
echo "</tr></table>\n";
?>
