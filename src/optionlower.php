<?php
		todos os usuarios
require_once("globals.php");

if(!ValidSession()) { // || $_SESSION["usertable"]["usertype"] == 'team') {
        InvalidSession("optionlower.php");
        ForceLoad("index.php");
}
$loc = $_SESSION['loc'];

if (isset($_GET["username"]) && isset($_GET["userfullname"]) && isset($_GET["userdesc"]) && 
    isset($_GET["passwordo"]) && isset($_GET["passwordn"])) {
	$username = myhtmlspecialchars($_GET["username"]);
	$userfullname = myhtmlspecialchars($_GET["userfullname"]);
	$userdesc = myhtmlspecialchars($_GET["userdesc"]);
	$passwordo = $_GET["passwordo"];
	$passwordn = $_GET["passwordn"];
	DBUserUpdate($_SESSION["usertable"]["contestnumber"],
		     $_SESSION["usertable"]["usersitenumber"],
		     $_SESSION["usertable"]["usernumber"],
		     $_SESSION["usertable"]["username"], // $username, but users should not change their names
		     $userfullname,
		     $userdesc,
		     $passwordo,
		     $passwordn);
	ForceLoad("option.php");
}

$a = DBUserInfo($_SESSION["usertable"]["contestnumber"],
                $_SESSION["usertable"]["usersitenumber"],
                $_SESSION["usertable"]["usernumber"]);

?>

<script language="JavaScript" src="<?php echo $loc; ?>/sha256.js"></script>
<script language="JavaScript" src="<?php echo $loc; ?>/hex.js"></script>
<script language="JavaScript">
function computeHASH()
{
	var username, userdesc, userfull, passHASHo, passHASHn;
	if (document.form1.passwordn1.value != document.form1.passwordn2.value) return;
	if (document.form1.passwordn1.value == document.form1.passwordo.value) return;
	username = document.form1.username.value;
	userdesc = document.form1.userdesc.value;
	userfull = document.form1.userfull.value;

	passHASHo = js_myhash(js_myhash(document.form1.passwordo.value)+'<?php echo session_id(); ?>');
	passHASHn = bighexsoma(js_myhash(document.form1.passwordn2.value),js_myhash(document.form1.passwordo.value));
	document.form1.passwordo.value = '                                                         ';
	document.form1.passwordn1.value = '                                                         ';
	document.form1.passwordn2.value = '                                                         ';
	document.location='option.php?username='+username+'&userdesc='+userdesc+'&userfullname='+userfull+'&passwordo='+passHASHo+'&passwordn='+passHASHn;
}
</script>

<br><br>
<form name="form1" action="javascript:computeHASH()">
  <center>
    <table border="0">
      <tr> 
        <td width="35%" align=right>Username:</td>
        <td width="65%">
	  <input type="text" readonly name="username" value="<?php echo $a["username"]; ?>" size="20" maxlength="20" />
        </td>
      </tr>
      <tr> 
        <td width="35%" align=right>User Full Name:</td>
        <td width="65%">
	  <input type="text" readonly name="userfull" value="<?php echo $a["userfullname"]; ?>" size="50" maxlength="50" />
        </td>
      </tr>
      <tr> 
        <td width="35%" align=right>User Description:</td>
        <td width="65%">
	  <input type="text" name="userdesc" value="<?php echo $a["userdesc"]; ?>" size="50" maxlength="250" />
        </td>
      </tr>
      <tr> 
        <td width="35%" align=right>Old Password:</td>
        <td width="65%">
	  <input type="password" name="passwordo" size="20" maxlength="200" />
        </td>
      </tr>
      <tr> 
        <td width="35%" align=right>New Password:</td>
        <td width="65%">
	  <input type="password" name="passwordn1" size="20" maxlength="200" />
        </td>
      </tr>
      <tr> 
        <td width="35%" align=right>Retype New Password:</td>
        <td width="65%">
	  <input type="password" name="passwordn2" size="20" maxlength="200" />
        </td>
      </tr>
    </table>
  </center>
  <center>
      <input type="submit" name="Submit" value="Send">
  </center>
</form>

</body>
</html>
