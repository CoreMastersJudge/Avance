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
	require_once($bocadir . $ds . '..' .$ds . 'version.php');
} else {
  if(is_readable($bocadir . $ds . 'db.php')) {
	require_once($bocadir . $ds . 'db.php');
	require_once($bocadir . $ds . 'version.php');
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

echo "\nType the contest number to re-insert the languages: ";
$resp = strtoupper(trim(fgets(STDIN)));
if(is_numeric($resp))
	insertlanguages($resp, null);
exit;
