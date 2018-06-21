<?php

require('header.php');
?>
<br>
<center><h2>Clarification List</h2></center>
<table width="100%" border=1>
 <tr>
  <td><b>#</b></td>
  <td><b>Site</b></td>
  <td><b>User</b></td>
  <td><b>Time</b></td>
  <td><b>Problem</b></td>
  <td><b>Status</b></td>
  <td><b>Judge (Site)</b></td>
  <td><b>Question</b></td>
  <td><b>Answer</b></td>
 </tr>
<?php
$s = $st;

if (trim($s["sitejudging"])!="") $s["sitejudging"].=",".$_SESSION["usertable"]["usersitenumber"];
else $s["sitejudging"]=$_SESSION["usertable"]["usersitenumber"];

$clar = DBAllClarsInSites($_SESSION["usertable"]["contestnumber"], $s["sitejudging"], 'report');

for ($i=0; $i<count($clar); $i++) {
  echo " <tr>\n";
  echo "  <td nowrap>" . $clar[$i]["number"] . "</td>\n";
  echo "  <td nowrap>" . $clar[$i]["site"] . "</td>\n";
  echo "  <td nowrap>" . $clar[$i]["user"] . "</td>\n";
  echo "  <td nowrap>" . dateconvminutes($clar[$i]["timestamp"]) . "</td>\n";
  echo "  <td nowrap>" . $clar[$i]["problem"] . "</td>\n";
  
  echo "  <td nowrap>" . $clar[$i]["status"] . "</td>\n";
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

include("$locr/footnote.php");
?>
