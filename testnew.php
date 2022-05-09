<?php
include("includes/initialize.php");
use Illuminate\Hashing\BcryptHasher;
$password='work'; 
 $xp = new BcryptHasher();
$pss = $xp->make($password, ['rounds' => 4]);

echo $pss;
?>