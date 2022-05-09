<?php
// If it's going to need the database, then it's 
// probably smart to require it before we start.

use Illuminate\Database\Eloquent\Model;
class Role_user extends Model {
	
	protected $table ="role_user";
	public $timestamps = true; 	 
	
}