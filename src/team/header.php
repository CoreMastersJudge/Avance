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
$runteam='run.php';

echo "<html><head><title>Team's Page</title>\n";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n";
echo "<link rel=stylesheet href=\"../Css.php\" type=\"text/css\">\n";

//echo "<meta http-equiv=\"refresh\" content=\"60\" />"; 

if(!ValidSession()) {
	InvalidSession("team/index.php");
        ForceLoad("../index.php");
}
if($_SESSION["usertable"]["usertype"] != "team") {
	IntrusionNotify("team/index.php");
        ForceLoad("../index.php");
}

echo "<script language=\"javascript\" src=\"../reload.js\"></script>\n";
echo "</head><body onload=\"Comecar()\" onunload=\"Parar()\"><table border=1 width=\"100%\">\n";
echo "<tr><td nowrap bgcolor=\"#aaaaee\" align=center>";
echo "<img src=\"../images/smallballoontransp.png\" alt=\"\">";
echo "<font color=\"#000000\">BOCA</font>";
echo "</td><td bgcolor=\"#aaaaee\" width=\"99%\">\n";
echo "Username: " . $_SESSION["usertable"]["userfullname"] . " (site=".$_SESSION["usertable"]["usersitenumber"].")\n";

$ds = DIRECTORY_SEPARATOR;
if($ds=="") $ds = "/";

$runtmp = $_SESSION["locr"] . $ds . "private" . $ds . "runtmp" . $ds . "run-contest" . $_SESSION["usertable"]["contestnumber"] . 
	"-site". $_SESSION["usertable"]["usersitenumber"] . "-user" . $_SESSION["usertable"]["usernumber"] . ".php";
$doslow=true;
if(file_exists($runtmp)) {
	if(($strtmp = file_get_contents($runtmp,FALSE,NULL,-1,1000000)) !== FALSE) {
		$postab=strpos($strtmp,"\t");
		$conf=globalconf();
		$strcolors = decryptData(substr($strtmp,$postab+1,strpos($strtmp,"\n")-$postab-1),$conf['key'],'');
		$doslow=false;
		$rn=explode("\t",$strcolors);
		$n=count($rn);
		for($i=1; $i<$n-1;$i++) {
			echo "<img alt=\"".$rn[$i]."\" width=\"10\" ".
				"src=\"" . balloonurl($rn[$i+1]) . "\" />\n";
			$i++;
		}
	} else unset($strtmp);
}
if($doslow) {
	$run = DBUserRunsYES($_SESSION["usertable"]["contestnumber"],
						 $_SESSION["usertable"]["usersitenumber"],
						 $_SESSION["usertable"]["usernumber"]);
	$n=count($run);
	for($i=0; $i<$n;$i++) {
		echo "<img alt=\"".$run[$i]["colorname"]."\" width=\"10\" ".
			"src=\"" . balloonurl($run[$i]["color"]) . "\" />\n";
	}
}

if(!isset($_SESSION["popuptime"]) || $_SESSION["popuptime"] < time()-120) {
	$_SESSION["popuptime"] = time();

	if(($st = DBSiteInfo($_SESSION["usertable"]["contestnumber"],$_SESSION["usertable"]["usersitenumber"])) != null) {
		$clar = DBUserClars($_SESSION["usertable"]["contestnumber"],
							$_SESSION["usertable"]["usersitenumber"],
							$_SESSION["usertable"]["usernumber"]);
		for ($i=0; $i<count($clar); $i++) {
			if ($clar[$i]["anstime"]>$_SESSION["usertable"]["userlastlogin"]-$st["sitestartdate"] && 
				$clar[$i]["anstime"] < $st['siteduration'] &&
				trim($clar[$i]["answer"])!='' && !isset($_SESSION["popups"]['clar' . $i . '-' . $clar[$i]["anstime"]])) {
				$_SESSION["popups"]['clar' . $i . '-' . $clar[$i]["anstime"]] = "(Clar for problem ".$clar[$i]["problem"]." answered)\n";
			}
		}
		$run = DBUserRuns($_SESSION["usertable"]["contestnumber"],
						  $_SESSION["usertable"]["usersitenumber"],
						  $_SESSION["usertable"]["usernumber"]);
		for ($i=0; $i<count($run); $i++) {
			if ($run[$i]["anstime"]>$_SESSION["usertable"]["userlastlogin"]-$st["sitestartdate"] && 
				$run[$i]["anstime"] < $st['sitelastmileanswer'] &&
				$run[$i]["ansfake"]!="t" && !isset($_SESSION["popups"]['run' . $i . '-' . $run[$i]["anstime"]])) {
				$_SESSION["popups"]['run' . $i . '-' . $run[$i]["anstime"]] = "(Run ".$run[$i]["number"]." result: ".$run[$i]["answer"] . ')\n';
			}
		}
	}

	$str = '';
	if(isset($_SESSION["popups"])) {
		foreach($_SESSION["popups"] as $key => $value) {
			if($value != '') {
				$str .= $value;
				$_SESSION["popups"][$key] = '';
			}
		}
		if($str != '') {
			MSGError('YOU GOT NEWS:\n' . $str . '\n');
		}
	}
}

list($clockstr,$clocktype)=siteclock();
echo "</td><td bgcolor=\"#aaaaee\" align=center nowrap>&nbsp;".$clockstr."&nbsp;</td></tr>\n";
echo "</table>\n";
echo "<table border=0 width=\"100%\" align=center>\n";
echo " <tr>\n";
echo "  <td align=center width=\"12%\"><a class=menu style=\"font-weight:bold\" href=problem.php>Problems</a></td>\n";
echo "  <td align=center width=\"12%\"><a class=menu style=\"font-weight:bold\" href=run.php>Runs</a></td>\n";
echo "  <td align=center width=\"12%\"><a class=menu style=\"font-weight:bold\" href=score.php>Score</a></td>\n";
echo "  <td align=center width=\"12%\"><a class=menu style=\"font-weight:bold\" href=clar.php>Clarifications</a></td>\n";
echo "  <td align=center width=\"12%\"><a class=menu style=\"font-weight:bold\" href=task.php>Tasks</a></td>\n";
echo "  <td align=center width=\"12%\"><a class=menu style=\"font-weight:bold\" href=files.php>Backups</a></td>\n";
echo "  <td align=center width=\"12%\"><a class=menu style=\"font-weight:bold\" href=option.php>Options</a></td>\n";
echo "  <td align=center width=\"12%\"><a class=menu style=\"font-weight:bold\" href=../index.php>Logout</a></td>\n";
echo " </tr>\n"; 
echo "</table>\n";
?>
