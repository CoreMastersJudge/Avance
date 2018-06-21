<?php

require_once('hex.php');

function create_zip($folder,$files,$destination,$msg=false,$zip=null) {
	if(!function_exists('zip_open')) {
		MSGError("Zip file error -- zip not installed (" . getFunctionName() .")");
		LogError("Zip file error -- zip not installed (" . getFunctionName() .")");
	}
	$ds = DIRECTORY_SEPARATOR;
	if($ds=="") $ds = "/";
	$dest=null;
	if($zip == null) {
		$zip = new ZipArchive();
		if($zip->open($destination,ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE) !== true) {
			return -1;
		}
		$dest=$destination;
		$destination='.';
	}
	foreach($files as $file) {
		if($msg)
			echo "Packing file " . $file . "\n";
		if(($pos = strrpos($file,$ds))!==false)
			$file = substr($file,$pos+1);
		if (is_dir($folder . $ds . $file) === true) {
			$zip->addEmptyDir($file);
			create_zip($folder . $ds . $file,
					   glob($folder . $ds . $file . $ds . '*'),$file,$msg,$zip);
		}
		else if (is_file($folder . $ds . $file) === true) {
			$zip->addFile($folder . $ds . $file, $destination . $ds . $file);
		}
    }
	if($dest != null) {
		$zip->close();
		if(file_exists($dest)) return 1; else return 0;
	} else return 1;
}

function unzipstr($str,$txt='') {
	$str = gzuncompress($str);
	$pos = strrpos($str,"#");
	$test2 = substr($str,$pos+1);
	$str = substr($str,0,$pos);
	$test1 = myshorthash($str);
	if($test1 != $test2) {
		if($txt=='')
			MSGError("Decompression error (" . getFunctionName() .")");
		LogError("Decompression error (" . getFunctionName() .",$txt)");
		return "";
	}
	return $str;
}
function zipstr($str) {
	if(!function_exists('gzcompress')) {
		MSGError("Compression error -- zlib not installed (" . getFunctionName() .")");
		LogError("Compression error -- zlib not installed (" . getFunctionName() .")");
	}
	return gzcompress($str . '#' . myshorthash($str));
}
?>
