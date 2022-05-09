<?php
require_once("includes/initialize.php");
$data = new Mysql_code_genrator();
global $database;
$table="crm";

$fdata = new formstruck();


$fromx= '';
 //$fromx=$fdata->select("Class","cl_id","sclass","cl_id",1).$fdata->co("input","name",1).$fdata->image("Image Upload","image").$fdata->text("small","small",1);
//$u=User::all();
//echo $x=json_encode($u);

//$data->create($table,$vrs);
$ro=$data->showlist($table,$fromx);
$data->createmodel($table,"includes/model/");
//echo $ro;
$data->cc($table,$fromx);
?>