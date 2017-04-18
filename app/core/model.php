<?php

class Model {

	public function __construct(){

		try{
			$this->db = new Database();
		} catch (PDOException $e){
			$error = 'Помилка підключення до бази даних: ' . $e->getMessage();
			echo $error;
			die();
		}

	}
}