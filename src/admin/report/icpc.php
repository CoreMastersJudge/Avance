<?php
require('header.php');

$score = DBScore($_SESSION["usertable"]["contestnumber"], false, -1, $st["siteglobalscore"]);

echo "<h2>ICPC Output</h2>";
echo "<pre>";
$n=0;
$class=1;
while(list($e, $c) = each($score)) {
	if(isset($score[$e]["site"]) && isset($score[$e]["user"])) {
		$r = DBUserInfo($_SESSION["usertable"]["contestnumber"], 
						$score[$e]["site"], $score[$e]["user"]);
		echo $r["usericpcid"] . ",";
		echo $class++ . ",";
		echo $score[$e]["totalcount"] . ",";
		echo $score[$e]["totaltime"] . ",";
		
		if($score[$e]["first"])
			echo $score[$e]["first"] . "\n";
		else echo "0\n";
		$n++;
	}
}
echo "</pre>";
?>
<?php include("$locr/footnote.php"); ?>

