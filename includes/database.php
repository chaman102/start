<?php
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Facade;
$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => DBDRIVER,
    'host'      => DB_SERVER,
    'database'  => DB_NAME,
    'username'  => DB_USER,
    'password'  => DB_PASS,
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => PREFIX,
]);

// Set the event dispatcher used by Eloquent models... (optional)

$capsule->setEventDispatcher(new Dispatcher(new Container));

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

$database = new Capsule();
$db = & $database;