<?php
require('header.php');

if(($ct = DBContestInfo($_SESSION["usertable"]["contestnumber"])) == null)
	ForceLoad("../index.php");
if(($st = DBSiteInfo($_SESSION["usertable"]["contestnumber"],$_SESSION["usertable"]["usersitenumber"])) == null)
        ForceLoad("../index.php");

if (isset($_POST["Submit"]) && $_POST["Submit"]=="S.O.S.") {
	if ($_POST["confirmation"] == "confirm") {
		$param['contest']=$_SESSION["usertable"]["contestnumber"];
		$param['site']=$_SESSION["usertable"]["usersitenumber"];
		$param['user']=$_SESSION["usertable"]["usernumber"];
		$param['desc']=  "Staff assistance";
		DBNewTask ($param);
	}
	ForceLoad("task.php");
}
if (isset($_FILES["filename"]) && isset($_POST["Submit"]) && $_FILES["filename"]["name"]!="") {
	if ($_POST["confirmation"] == "confirm") {
		$type=myhtmlspecialchars($_FILES["filename"]["type"]);
		$size=myhtmlspecialchars($_FILES["filename"]["size"]);
		$name=myhtmlspecialchars($_FILES["filename"]["name"]);
		$temp=myhtmlspecialchars($_FILES["filename"]["tmp_name"]);

		if ($size > $ct["contestmaxfilesize"]) {
	                LOGLevel("User {$_SESSION["usertable"]["username"]} tried to print file " .
			"$name with $size bytes ({$ct["contestmaxfilesize"]} max allowed).", 1);
			MSGError("File size exceeds the limit allowed.");
			ForceLoad("task.php");
		}
		if (!is_uploaded_file($temp)) {
			IntrusionNotify("Printing file upload problem");
			ForceLoad("../index.php");
		}
		$param['contest']=$_SESSION["usertable"]["contestnumber"];
		$param['site']=$_SESSION["usertable"]["usersitenumber"];
		$param['user']=$_SESSION["usertable"]["usernumber"];
		$param['desc']= "File to print";
		$param['filename']=$name;
		$param['filepath']=$temp;
		DBNewTask ($param);
	}
	ForceLoad("task.php");
}
?>
<br>
<table width="100%" border=1>
 <tr>
  <td><b>Task #</b></td>
  <td><b>Time</b></td>
  <td><b>Description</b></td>
  <td><b>File</b></td>
  <td><b>Status</b></td>
 </tr>
<?php
$task = DBUserTasks($_SESSION["usertable"]["contestnumber"],
		  $_SESSION["usertable"]["usersitenumber"],
		  $_SESSION["usertable"]["usernumber"]);
for ($i=0; $i<count($task); $i++) {
  echo " <tr>\n";
  echo "  <td nowrap>" . $task[$i]["number"] . "</td>\n";
  echo "  <td nowrap>" . dateconvminutes($task[$i]["timestamp"]) . "</td>\n";
  echo "  <td nowrap>" . $task[$i]["description"] . "</td>\n";
  echo "  <td nowrap>" . $task[$i]["filename"] . "&nbsp;</td>\n";
  echo "  <td nowrap>" . $task[$i]["status"] . "</td>\n";
}
echo "</table>";
if (count($task) == 0) echo "<br><center><b><font color=\"#ff0000\">NO TASKS FOUND</font></b></center>";
?>

<br><br><center><b>To submit a file for printing, just fill in the following field:</b></center>
<form name="form1" enctype="multipart/form-data" method="post" action="task.php">
<!--<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $ct["contestmaxfilesize"] ?>">-->
  <input type=hidden name="confirmation" value="noconfirm" />
  <center>
    <table border="0">
      <tr> 
        <td width="25%" align=right>File name:</td>
        <td width="75%">
	  <input type="file" name="filename" size="40" onclick="Arquivo()">
        </td>
      </tr>
    </table>
  </center>
  <script language="javascript">
    function conf() {
      if (confirm("Confirm?")) {
        document.form1.confirmation.value='confirm';
      }
    }
  </script>
  <center>
      <input type="submit" name="Submit" value="Send" onClick="conf()">
      <input type="reset" name="Submit2" value="Clear">
  </center>
<br><br><center><b>If you needed staff assistance, please click
on the button above and wait.</b><br>
      <input type="submit" name="Submit" value="S.O.S." onClick="conf()">
  </center>
</form>

</body>
</html>
