<?php
require('header.php');

if(($ct = DBContestInfo($_SESSION["usertable"]["contestnumber"])) == null)
	ForceLoad("$loc/index.php");
if(($st = DBSiteInfo($_SESSION["usertable"]["contestnumber"],$_SESSION["usertable"]["usersitenumber"])) == null)
        ForceLoad("$loc/index.php");

if (isset($_GET["delete"]) && is_numeric($_GET["delete"])) {
   DBBkpDelete($_GET["delete"],$_GET["usersitenumber"],$_SESSION["usertable"]["contestnumber"], $_GET["usernumber"],$_SESSION["usertable"]["username"]);
   ForceLoad("files.php");
}
?>
<br>
  <script language="javascript">
    function conf2(url) {
      if (confirm("Confirm DELETION of file?")) {
        document.location=url;
      } else {
        document.location='files.php';
      }
    }
  </script>
<table width="100%" border=1>
 <tr>
  <td><b>Bkp #</b></td>
  <td><b>Time</b></td>
  <td><b>User(Site)</b></td>
  <td><b>File</b></td>
  <td><b>Status</b></td>
 </tr>
<?php
$run = DBUserBkps($_SESSION["usertable"]["contestnumber"], -1, -1);

for ($i=0; $i<count($run); $i++) {
  echo " <tr>\n";
  if(strpos($run[$i]["status"],"deleted")!==false)
	  echo "  <td nowrap>" . $run[$i]["number"] . "</td>\n";
  else
	  echo "  <td nowrap><a href=\"javascript:conf2('files.php?delete=" . $run[$i]["number"] .
		  "&usernumber=" .$run[$i]["usernumber"]. "&usersitenumber=" .$run[$i]["usersitenumber"]. "')\">" . $run[$i]["number"] . "</a></td>\n";

  echo "  <td nowrap>" . dateconvsimple($run[$i]["timestamp"]) . "</td>\n";
  echo "  <td nowrap>" . $run[$i]["usernumber"] . " (" . $run[$i]["usersitenumber"] . ")</td>\n";
  $if = rawurlencode($run[$i]["filename"]);
  if($run[$i]["status"]=="active") {
    echo "<td nowrap><a href=\"../filedownload.php?". filedownload($run[$i]["oid"],$run[$i]["filename"]) . "\">";
    echo $run[$i]["filename"] . "</a>";
  } else echo "<td>" . $run[$i]["filename"];
  echo " (" . $run[$i]["size"] . " bytes)";
  echo "</td>\n";
  echo "<td>" . $run[$i]["status"] . "</td>\n";
  echo " </tr>\n";

}
echo "</table>";
if (count($run) == 0) echo "<br><center><b><font color=\"#ff0000\">NO BACKUPS AVAILABLE</font></b></center>";

?>
</body>
</html>
