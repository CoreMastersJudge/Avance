<?php
require 'header.php';

if (isset($_GET)) {
}
?>
<br><br>
  <center>
<?php
      echo " <a href=\"#\" class=menu style=\"font-weight:bold\" onClick=\"window.open('report/score.php?p=2', ".
		"'Complete Scoreboard','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
		"resizable=yes')\">Scoreboard</a><br />\n";
      echo " <a href=\"#\" class=menu style=\"font-weight:bold\" onClick=\"window.open('report/score.php?p=0', ".
		"'Complete Scoreboard','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
		"resizable=yes')\">Detailed Scoreboard</a><br />\n";
      echo " <a href=\"#\" class=menu style=\"font-weight:bold\" onClick=\"window.open('report/score.php?p=0&hor=0', ".
		"'Complete Scoreboard','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
		"resizable=yes')\">Interactive Scoreboard</a><br />\n";
      echo " <a href=\"#\" class=menu style=\"font-weight:bold\" onClick=\"window.open('report/score.php?p=1', ".
		"'Public Scoreboard','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
		"resizable=yes')\">Delayed Scoreboard</a><br />\n";
      echo " <a href=\"#\" class=menu style=\"font-weight:bold\" onClick=\"window.open('report/run.php', ".
		"'Run List','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
		"resizable=yes')\">Run List</a><br />\n";
      echo " <a href=\"#\" class=menu style=\"font-weight:bold\" onClick=\"window.open('report/clar.php', ".
		"'Clarification List','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
		"resizable=yes')\">Clarification List</a><br />\n";
      echo " <a href=\"#\" class=menu style=\"font-weight:bold\" onClick=\"window.open('report/task.php', ".
		"'Task List','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
		"resizable=yes')\">Task List</a><br />\n";
      echo " <a href=\"#\" class=menu style=\"font-weight:bold\" onClick=\"window.open('report/site.php', ".
		"'Start/Stop Logs','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
		"resizable=yes')\">Site Start/Stop Logs</a><br />\n";
      echo " <a href=\"#\" class=menu style=\"font-weight:bold\" onClick=\"window.open('report/icpc.php', ".
		"'ICPC File','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
		"resizable=yes')\">ICPC File</a><br />\n";

      echo " <a href=\"#\" class=menu style=\"font-weight:bold\" onClick=\"window.open('report/webcast.php', ".
		"'Webcast File','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
		"resizable=yes')\">Webcast File</a><br />\n";

      echo " <a href=\"#\" class=menu style=\"font-weight:bold\" onClick=\"window.open('report/s4ris.php', ".
		"'S4ris File','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
		"resizable=yes')\">S4RiS File</a><br />\n";

      echo " <a href=\"#\" class=menu style=\"font-weight:bold\" onClick=\"window.open('report/stat.php', ".
		"'Problem Statistics','width=800,height=600,scrollbars=yes,toolbar=yes,menubar=yes,".
		"resizable=yes')\">Statistics</a><br />\n";
?>
  </center>
</form>

</body>
</html>
