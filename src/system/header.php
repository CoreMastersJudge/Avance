<?php

ob_start();
header ("Expires: " . gmdate("D, d M Y H:i:s") . " GMT");
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");
header ("Content-Type: text/html; charset=utf-8");
session_start();
ob_end_flush();
require_once('../version.php');

require_once("../globals.php");
require_once("../db.php");

echo "<html><head><title>System's Page</title>\n";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n";
echo "<link rel=stylesheet href=\"../Css.php\" type=\"text/css\">\n";

//echo "<meta http-equiv=\"refresh\" content=\"60\" />";
if(!ValidSession()) {
	InvalidSession("system/index.php");
        ForceLoad("../index.php");
}
if($_SESSION["usertable"]["usertype"] != "system") {
	IntrusionNotify("system/index.php");
        ForceLoad("../index.php");
}

echo "</head><body><table border=1 width=\"100%\">\n";
echo "<tr><td nowrap bgcolor=\"eeee00\" align=center>";
echo "<img src=\"../images/smallballoontransp.png\" alt=\"\">";
echo "<font color=\"#000000\">BOCA</font>";
echo "</td><td bgcolor=\"#eeee00\" width=\"99%\">\n";
echo "Username: " . $_SESSION["usertable"]["userfullname"] ."<br>\n";
list($clockstr,$clocktype)=siteclock();
echo "</td><td bgcolor=\"#eeee00\" align=center nowrap>&nbsp;".$clockstr."&nbsp;</td></tr>\n";
echo "</table>\n";
echo "<table border=0 width=\"100%\" align=center>\n";
echo " <tr>\n";
echo "  <td align=center><a class=menu style=\"font-weight:bold\" href=contest.php>Contest</a></td>\n";
//echo "  <td align=center><a class=menu style=\"font-weight:bold\" href=importxml.php>Import</a></td>\n";
echo "  <td align=center><a class=menu style=\"font-weight:bold\" href=option.php>Options</a></td>\n";
echo "  <td align=center><a class=menu style=\"font-weight:bold\" href=../index.php>Logout</a></td>\n";
echo " </tr>\n"; 
echo "</table>\n";
?>
