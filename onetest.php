<?php
include("includes/initialize.php");

function encode2($str) {
    $str = mb_convert_encoding($str , 'UTF-32', 'UTF-8');
    $t = unpack("N*", $str);
    $t = array_map(function($n) { return "&#$n;"; }, $t);
    return implode("", $t);
}

global $database;

$x=$database::table('ntest')->get();
echo '<pre>';
foreach($x as $key => $val)
{
	$message_convert = encode2($val->name); 

	echo mb_convert_encoding($message_convert, "HTML-ENTITIES", "auto");
	echo '<br>';
	}

?>