<?php
require('header.php');
?>

<br>
<table width="100%" border=1>
 <tr>
  <td><b>Run #</b></td>
  <td><b>Site</b></td>
  <td><b>Time</b></td>
  <td><b>Problem</b></td>
  <td><b>Language</b></td>
<!--  <td><b>Filename</b></td> -->
  <td><b>Status</b></td>
  <td><b>AJ</b></td>
  <td><b>Answer</b></td>
 </tr>
<?php
if (($s=DBSiteInfo($_SESSION["usertable"]["contestnumber"],$_SESSION["usertable"]["usersitenumber"])) == null)
        ForceLoad("../index.php");

$run = DBOpenRunsInSites($_SESSION["usertable"]["contestnumber"], $s["sitejudging"]);

for ($i=0; $i<count($run); $i++) {
  echo " <tr>\n";
  echo "  <td nowrap><a href=\"runedit.php?runnumber=".$run[$i]["number"]."&runsitenumber=".$run[$i]["site"] .
         "\">" . $run[$i]["number"] . "</td>\n";
  echo "  <td nowrap>" . $run[$i]["site"] . "</td>\n";
  echo "  <td nowrap>" . dateconvminutes($run[$i]["timestamp"]) . "</td>\n";
  echo "  <td nowrap>" . $run[$i]["problem"] . "</td>\n";
  echo "  <td nowrap>" . $run[$i]["language"] . "</td>\n";
  if ($run[$i]["judge1"] == $_SESSION["usertable"]["usernumber"] && 
      $run[$i]["judgesite1"] == $_SESSION["usertable"]["usersitenumber"])
    $color="ff7777";
  else if ($run[$i]["judge2"] == $_SESSION["usertable"]["usernumber"] && 
      $run[$i]["judgesite2"] == $_SESSION["usertable"]["usersitenumber"])
    $color="ff7777";
  else if ($run[$i]["status"] == "judged+") $color="ffff00";
  else if ($run[$i]["status"] == "judged") $color="0000ff";
  else if ($run[$i]["status"] == "judging") $color="77ff77";
  else if ($run[$i]["status"] == "openrun") $color="ffff88";
  else $color="ffffff";

  echo "  <td nowrap bgcolor=\"#$color\">" . $run[$i]["status"] . "</td>\n";
  if ($run[$i]["autoend"] != "") {
    $color="bbbbff";
    if ($run[$i]["autoanswer"]=="") $color="ff7777";
  }
  else if ($run[$i]["autobegin"]=="") $color="ffff88";
  else $color="77ff77";
  echo "<td bgcolor=\"#$color\">&nbsp;&nbsp;</td>\n";

  if ($run[$i]["answer"] == "") $run[$i]["answer"] = "&nbsp;";
  echo "  <td>" . $run[$i]["answer"] . "</td>\n";
  echo " </tr>\n";
}

echo "</table>";
if (count($run) == 0) echo "<br><center><b><font color=\"#ff0000\">NO RUNS AVAILABLE</font></b></center>";

?>
</body>
</html>
