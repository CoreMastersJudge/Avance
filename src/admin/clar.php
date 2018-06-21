<?php
require 'header.php';
if (isset($_POST["message"]) && isset($_POST["problem"]) && isset($_POST["Submit"])) {
	if ($_POST["confirmation"] == "confirm") {
		$param['contest']=$_SESSION["usertable"]["contestnumber"];
		$param['site']=$_SESSION["usertable"]["usersitenumber"];
		$param['user']= $_SESSION["usertable"]["usernumber"];
		$param['problem'] = htmlspecialchars($_POST["problem"]);
		$param['question'] = htmlspecialchars($_POST["message"]);
		DBNewClar($param);
	}
	ForceLoad("clar.php");
}
if(isset($_GET["order"]) && $_GET["order"] != "") {
	$order = htmlspecialchars($_GET["order"]);
	$_SESSION["clarline"] = $order;
} else {
	if(isset($_SESSION["clarline"]))
		$order = $_SESSION["clarline"];
	else
		$order='';
}
?>
<br>
<table width="100%" border=1>
 <tr>
  <td><b><a href="clar.php?order=clar">Clar #</a></b></td>
  <td><b><a href="clar.php?order=site">Site</a></b></td>
  <td><b><a href="clar.php?order=user">User</a></b></td>
  <td><b>Time</b></td>
  <td><b><a href="clar.php?order=problem">Problem</a></b></td>
  <td><b><a href="clar.php?order=status">Status</a></b></td>
  <td><b><a href="clar.php?order=judge">Judge (Site)</a></b></td>
  <td><b>Question</b></td>
  <td><b>Answer</b></td>
 </tr>
<?php

if(($s = DBSiteInfo($_SESSION["usertable"]["contestnumber"], $_SESSION["usertable"]["usersitenumber"])) == null)
	ForceLoad("$loc/index.php");


if (trim($s["sitejudging"])!="") $s["sitejudging"].=",".$_SESSION["usertable"]["usersitenumber"];
else $s["sitejudging"]=$_SESSION["usertable"]["usersitenumber"];

$clar = DBAllClarsInSites($_SESSION["usertable"]["contestnumber"], $s["sitejudging"], $order);

for ($i=0; $i<count($clar); $i++) {
  echo " <tr>\n";
  echo "  <td nowrap><a href=\"claredit.php?clarnumber=".$clar[$i]["number"]."&clarsitenumber=".$clar[$i]["site"] .
       "\">" . $clar[$i]["number"] . "</a></td>\n";
  echo "  <td nowrap>" . $clar[$i]["site"] . "</td>\n";
  echo "  <td nowrap>" . $clar[$i]["user"] . "</td>\n";
  echo "  <td nowrap>" . dateconvminutes($clar[$i]["timestamp"]) . "</td>\n";
  echo "  <td nowrap>" . $clar[$i]["problem"] . "</td>\n";
  if ($clar[$i]["judge"] == $_SESSION["usertable"]["usernumber"] &&
      $clar[$i]["judgesite"] == $_SESSION["usertable"]["usersitenumber"] && $clar[$i]["status"] == "answering")
    $color="ff7777";
  else if (strpos($clar[$i]["status"], "answered") !== false) $color="bbbbff";
  else if ($clar[$i]["status"] == "answering") $color="77ff77";
  else if ($clar[$i]["status"] == "openclar") $color="ffff88";
  else $color="ffffff";

  echo "  <td nowrap bgcolor=\"#$color\">" . $clar[$i]["status"] . "</td>\n";
  if ($clar[$i]["judge"] != "") {
    $u = DBUserInfo ($_SESSION["usertable"]["contestnumber"], $clar[$i]["judgesite"], $clar[$i]["judge"]);
    echo "  <td nowrap>" . $u["username"] . " (" . $clar[$i]["judgesite"] . ")</td>\n";
  }
  else
    echo "  <td>&nbsp;</td>\n";

  if ($clar[$i]["question"] == "") $clar[$i]["question"] = "&nbsp;";

  echo "  <td>";

  echo "  <textarea name=\"m$i\" cols=\"60\" rows=\"8\" readonly>".$clar[$i]["question"]."</textarea>\n";
  echo "</td>\n";
  if (trim($clar[$i]["answer"]) == "") $clar[$i]["answer"] = "Not answered yet";
  echo "  <td>";

  echo "  <textarea name=\"a$i\" cols=\"60\" rows=\"8\" readonly>".$clar[$i]["answer"]."</textarea>\n";
  echo "</td>\n";

  echo " </tr>\n";
}

echo "</table>";
if (count($clar) == 0) echo "<br><center><b><font color=\"#ff0000\">NO CLARIFICATIONS AVAILABLE</font></b></center>";

?>
</body>
</html>
