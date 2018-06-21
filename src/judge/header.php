<?php
ob_start();
header ("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-Type: text/html; charset=utf-8");
session_start();
ob_end_flush();
require('../version.php');
require_once("../globals.php");
require_once("../db.php");

$runteam='team.php';
$runphp = "runchief.php";
$runeditphp = "runeditchief.php";

echo "<html><head><title>Judge's Page</title>\n";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n";
echo "<link rel=stylesheet href=\"../Css.php\" type=\"text/css\">\n";

if(!ValidSession()) {
	InvalidSession("judge/index.php");
        ForceLoad("../index.php");
}
if($_SESSION["usertable"]["usertype"] != "judge") {
	IntrusionNotify("judge/index.php");
        ForceLoad("../index.php");
}

if(($s = DBSiteInfo($_SESSION["usertable"]["contestnumber"], $_SESSION["usertable"]["usersitenumber"])) == null)
        ForceLoad("../index.php");

if($s["sitechiefname"]== $_SESSION["usertable"]["username"])
  $cc = "338833";
else
  $cc = "77cc77";


echo "<script language=\"javascript\" src=\"../reload.js\"></script>\n";
echo "</head><body onload=\"Comecar()\" onunload=\"Parar()\"><table border=1 width=\"100%\">\n";
echo "<tr><td nowrap bgcolor=\"#$cc\" align=center>";
echo "<img src=\"../images/smallballoontransp.png\" alt=\"\">";
echo "<font color=\"#000000\">BOCA</font>";
echo "</td><td bgcolor=\"#$cc\" width=\"99%\">\n";
echo "Username: " . $_SESSION["usertable"]["userfullname"] . " (site=".$_SESSION["usertable"]["usersitenumber"].")<br>\n";
list($clockstr,$clocktype)=siteclock();
echo "</td><td bgcolor=\"#$cc\" align=center nowrap>&nbsp;".$clockstr."&nbsp;</td></tr>\n";
echo "</table>\n";

$clar = DBOpenClarsInSites($_SESSION["usertable"]["contestnumber"], $s["sitejudging"]);
$run = DBOpenRunsInSites($_SESSION["usertable"]["contestnumber"], $s["sitejudging"]);
if($s["sitechiefname"]== $_SESSION["usertable"]["username"]) {
$nrchief = 0;
$rrun = DBAllRunsInSites($_SESSION["usertable"]["contestnumber"], $s["sitejudging"]);
for ($i=0; $i<count($rrun); $i++) {
  if($rrun[$i]["answer1"] != 0 && $rrun[$i]["answer2"] != 0 && $rrun[$i]["status"] != "judged")
    $nrchief++;
}
}
$nr=count($run);
$nc=count($clar);

echo "<table border=0 width=\"100%\" align=center>\n";
echo " <tr>\n";
echo "  <td align=center width=\"10%\"><a class=menu style=\"font-weight:bold\" href=run.php>Runs ($nr)</a></td>\n";
if($s["sitechiefname"]== $_SESSION["usertable"]["username"]) {
  echo "  <td align=center width=\"10%\"><a class=menu style=\"font-weight:bold\" href=runchief.php>Chief ($nrchief)</a></td>\n";
}
echo "  <td align=center width=\"10%\"><a class=menu style=\"font-weight:bold\" href=score.php>Score</a></td>\n";
echo "  <td align=center width=\"10%\"><a class=menu style=\"font-weight:bold\" href=clar.php>Clarifications ($nc)</a></td>\n";

echo "  <td align=center width=\"10%\"><a class=menu style=\"font-weight:bold\" href=history.php>History</a></td>\n";
echo "  <td align=center width=\"10%\"><a class=menu style=\"font-weight:bold\" href=team.php>As Team</a></td>\n";
echo "  <td align=center width=\"10%\"><a class=menu style=\"font-weight:bold\" href=option.php>Options</a></td>\n";
echo "  <td align=center width=\"10%\"><a class=menu style=\"font-weight:bold\" href=../index.php>Logout</a></td>\n";
echo " </tr>\n"; 
echo "</table>\n";
?>
