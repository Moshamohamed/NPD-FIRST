<?php

return array(
	/*
	|--------------------------------------------------------------------------
	|                       =====> Database Connection  <=====
	|--------------------------------------------------------------------------
	|
	| Here you may specify which of the database connections below you wish
	| to use as your default connection for all database work..
	|
	*/
	// SQL DATABASE
   'db' => array(
       'driver'      => 'mysql',
       'api'         => 'PDO', // pdo or mysqli onyl for mysql data base
       'server'      => 'localhost' ,
       'db_name'     => 'awc',
       'db_user'     => 'root',
       'db_password' => '123',
       'fetch'       => PDO::FETCH_ASSOC, // used only with pdo
   ),

);