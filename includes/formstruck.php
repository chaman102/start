<?php
require_once (LIB_PATH . DS . 'database.php');

class formstruck
	{
		
	public static function co($type="",$name="",$n)
	 {
		$x='echo $fo=Forms::'.strtolower($type).'("'.ucfirst($name).'","'.$name.'",$'.$name.','.$n.');'."		
		";		
		return $x; 
	 }
	 	
	 public static function text($lable="",$name="",$n)
	 {
		$x='echo $fo=Forms::text_editor("'.ucfirst($lable).'","'.$name.'",$'.$name.',"'.$name.'",'.$n.');
		';
		return $x; 
	 }
	public static function select($lable="",$name="",$table,$t,$n)
	 {
		$x='echo $fo=Forms::select("'.ucfirst($lable).'","'.$name.'","'.$table.'",$'.$t.','.$n.');
		';
		return $x; 
	 }
	 public static function image($lable="",$name="")
	 {
		 $m='impath';
		 $im='image';
		$x='echo $fo=Forms::img("'.ucfirst($lable).'","'.$name.'",$'.$m.',$'.$im.');
		';
		return $x; 
	 }	
	 public static function date($lable="",$name="",$t,$id,$n)
	 {
		$x='echo $fo=Forms::date_mm("'.ucfirst($lable).'","'.$name.'",$'.$t.',$'.$id.','.$n.');
		';
		return $x; 
	 }	
	}