<?php

class Model_User extends Model {

	public function __construct() {
		parent::__construct();
	}


	public function registration($name, $mail, $pass){

		$query = $this->db->prepare("SELECT id FROM users WHERE email=?");
		$query->execute([$mail]);
		$data = $query->fetchAll(PDO::FETCH_ASSOC);

		if(count($data) != 0) {
			return $error = "Дана електронна почта уже зареєстована. ";
		} else {
			$query = $this->db->prepare("INSERT INTO users (users.name, email, password) VALUES (?, ?, ?)");
			$query->execute([ $name, $mail, md5(md5($pass)) ]);
			return false;
		}
	}


	public function login($login, $pass){

		$password = md5(md5($pass));
		$query = $this->db->prepare("SELECT id, users.name, image FROM users WHERE users.email = ? AND users.password = ?");
		$query->execute([$login, $password]);
		$data = $query->fetchAll(PDO::FETCH_ASSOC);

		if(count($data) == 0) {
			return false;
		} else {
			return $data[0];
		}
	}

	public function get_id($email){

		$query = $this->db->prepare("SELECT id, image FROM users WHERE users.email = ?");
		$query->execute([$email]);
		$data = $query->fetchAll(PDO::FETCH_ASSOC);
		return $data[0];
	}

}
