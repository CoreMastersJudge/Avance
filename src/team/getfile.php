<?php
require 'header.php';

if(($ct = DBContestInfo($_SESSION["usertable"]["contestnumber"])) == null)
	ForceLoad("../index.php");
if(($st = DBSiteInfo($_SESSION["usertable"]["contestnumber"],$_SESSION["usertable"]["usersitenumber"])) == null)
        ForceLoad("../index.php");

$fn = tempnam("/tmp","bkp-");
$fout = fopen($fn,"wb");
//echo $_POST;
//echo $_POST['data'];
fwrite($fout,base64_decode($_POST['data']));
fclose($fout);
$size=filesize($fn);
$name=$_POST['name'];
		if ($size > $ct["contestmaxfilesize"] || strlen($name)>100 || strlen($name)<1) {
	                LOGLevel("User {$_SESSION["usertable"]["username"]} tried to submit file " .
			":${name}: with $size bytes.", 1);
			MSGError("File size exceeds the limit allowed or invalid name.");
		} else

		DBNewBkp ($_SESSION["usertable"]["contestnumber"],
	                  $_SESSION["usertable"]["usersitenumber"],
	                  $_SESSION["usertable"]["usernumber"],
			  $name,
			  $fn, $size);
@unlink($fn);
ForceLoad("../index.php");
?>
