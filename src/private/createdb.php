#!/usr/bin/php
<?php

$ds = DIRECTORY_SEPARATOR;
if($ds=="") $ds = "/";

if(is_readable('/etc/boca.conf')) {
	$pif=parse_ini_file('/etc/boca.conf');
	$bocadir = trim($pif['bocadir']) . $ds . 'src';
} else {
	$bocadir = getcwd();
}

if(is_readable($bocadir . $ds . '..' .$ds . 'db.php')) {
	require_once($bocadir . $ds . '..' .$ds . 'db.php');
	@include_once($bocadir . $ds . '..' .$ds . 'version.php');
} else {
  if(is_readable($bocadir . $ds . 'db.php')) {
	require_once($bocadir . $ds . 'db.php');
	@include_once($bocadir . $ds . 'version.php');
  } else {
	  echo "unable to find db.php";
	  exit;
  }
}
if (getIP()!="UNKNOWN" || php_sapi_name()!=="cli") exit;
ini_set('memory_limit','600M');
ini_set('output_buffering','off');
ini_set('implicit_flush','on');
@ob_end_flush();

if(system('test "`id -u`" -eq "0"',$retval)===false || $retval!=0) {
	echo "Must be run as root\n";
	exit;
}
echo "\nThis will erase all the data in your bocadb database.";
echo "\n***** YOU WILL LOSE WHATEVER YOU HAVE THERE!!! *****";
echo "\nType YES and press return to continue or anything else will abort it: ";
$resp = strtoupper(trim(fgets(STDIN)));
if($resp != 'YES') exit;

echo "\ndropping database\n";
DBDropDatabase();
echo "creating database\n";
DBCreateDatabase();
echo "creating tables\n";
DBCreateContestTable();
DBCreateSiteTable();
DBCreateSiteTimeTable();
DBCreateUserTable();
DBCreateLogTable();
DBCreateProblemTable();
DBCreateAnswerTable();
DBCreateTaskTable();
DBCreateLangTable();
DBCreateRunTable();
DBCreateClarTable();
DBCreateBkpTable();
echo "creating initial fake contest\n";
DBFakeContest();
?>
