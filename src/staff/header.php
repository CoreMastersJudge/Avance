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

echo "<html><head><title>Staff's Page</title>\n";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n";
echo "<link rel=stylesheet href=\"../Css.php\" type=\"text/css\">\n";

//echo "<meta http-equiv=\"refresh\" content=\"60\" />"; 

if(!ValidSession()) {
	InvalidSession("staff/index.php");
        ForceLoad("../index.php");
}
if($_SESSION["usertable"]["usertype"] != "staff"
  && $_SESSION["usertable"]["usertype"] != "admin") {
	IntrusionNotify("staff/index.php");
        ForceLoad("../index.php");
}

echo "<script language=\"javascript\" src=\"../reload.js\"></script>\n";
echo "</head><body onload=\"Comecar()\" onunload=\"Parar()\"><table border=1 width=\"100%\">\n";
echo "<tr><td nowrap bgcolor=\"#ffa020\" align=center>";
echo "<img src=\"../images/smallballoontransp.png\" alt=\"\">";
echo "<font color=\"#000000\">BOCA</font>";
echo "</td><td bgcolor=\"#ffa020\" width=\"99%\">\n";
echo "Username: " . $_SESSION["usertable"]["userfullname"] . " (site=".$_SESSION["usertable"]["usersitenumber"].")<br>\n";
list($clockstr,$clocktype)=siteclock();
echo "</td><td bgcolor=\"#ffa020\" align=center nowrap>&nbsp;".$clockstr."&nbsp;</td></tr>\n";
echo "</table>\n";

if(($s = DBSiteInfo($_SESSION["usertable"]["contestnumber"], $_SESSION["usertable"]["usersitenumber"])) == null)
        ForceLoad("../index.php");

//$task = DBOpenTasksInSites($_SESSION["usertable"]["contestnumber"], $s["sitetasking"]);
//$nr=count($task);

echo "<table border=0 width=\"100%\" align=center>\n";
echo " <tr>\n";
echo "  <td align=center width=\"20%\"><a class=menu style=\"font-weight:bold\" href=task.php>Tasks</a></td>\n";
//echo "  <td align=center width=\"20%\"><a class=menu style=\"font-weight:bold\" href=task.php>Tasks ($nr)</a></td>\n";
echo "  <td align=center width=\"20%\"><a class=menu style=\"font-weight:bold\" href=score.php>Score</a></td>\n";
echo "  <td align=center width=\"20%\"><a class=menu style=\"font-weight:bold\" href=run.php>Runs</a></td>\n";

//echo " <td align=center width=\"20%\"><a href=\"#\" class=menu style=\"font-weight:bold\" onClick=\"window.open('report/stat.php', ".
//                "'Problem Statistics','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
//                "resizable=yes')\">Statistics</a></td>\n";

//echo "  <td align=center width=\"20%\"><a class=menu style=\"font-weight:bold\" href=option.php>Options</a></td>\n";
echo "  <td align=center width=\"20%\"><a class=menu style=\"font-weight:bold\" href=../index.php>Logout</a></td>\n";
echo " </tr>\n"; 
echo "</table>\n";
?>

