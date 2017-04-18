<?php

class Database extends PDO {

	protected $db;

	public function __construct(){

		parent::__construct( DB_TYPE. ':host='. DB_HOST .';dbname='. DB_NAME.';charset=utf8', DB_USER, DB_PASS);
	}
}