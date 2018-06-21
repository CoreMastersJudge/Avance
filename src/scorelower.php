<?php

require_once("globals.php");

if(!ValidSession()) {
        InvalidSession("scorelower.php");
        ForceLoad("index.php");
}

if (($s = DBSiteInfo($_SESSION["usertable"]["contestnumber"],$_SESSION["usertable"]["usersitenumber"])) == null)
  ForceLoad("../index.php");

if ($_SESSION["usertable"]["usertype"]!="judge" &&
    $_SESSION["usertable"]["usertype"]!="admin") $ver=true;
else $ver=false;
if($_SESSION["usertable"]["usertype"]=="score") $des=false;
else $des=true;

if ($s["currenttime"] >= $s["sitelastmilescore"] && $ver)
	echo "<br><center>Scoreboard frozen</center>";

require('scoretable.php');
?>

</body>
</html>
