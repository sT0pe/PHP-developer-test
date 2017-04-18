<?php

class Controller_User extends Controller {

	function login() {
		$this->model = new Model_User();

		$result = $this->model->login( $_POST['email'], $_POST['password'] );

		if( $result ){

			$_SESSION['user_id']   = $result['id'];
			$_SESSION['user_name'] = $result['name'];
			$_SESSION['image']     = $result['image'];
		} else {
			$_SESSION['errors'][] = 'Невірно введені дані!';
		}

		header('Location:/home');
	}

	function registration() {
		include 'app/core/validation.php';
		$this->model = new Model_User();

		$name = trim($_POST['name']);
		$password = trim($_POST['password']);

		if( Validation::login( $name ) ){
			$_SESSION['errors'][] = Validation::login( $name );
		}
		if( Validation::password( $password ) ){
			$_SESSION['errors'][] = Validation::password( $password );
		}

		if(!isset($_SESSION['errors'])){
			$this->model = new Model_User();
			$result = $this->model->registration( $name, $_POST['email'], $password );

			if($result){
				$_SESSION['errors'][] = $result;
			} else {
				$_SESSION['success'] = 'Ви успішно зареєстровані!';
				$_SESSION['user_name'] = $name;
				$_SESSION['user_id'] = $this->model->get_id($_POST['email']);
				$_SESSION['user_id'] = $_SESSION['user_id']['id'];
				$_SESSION['image']   = $this->model->get_id($_POST['email']);
				$_SESSION['image']   = $_SESSION['image']['image'];
			}
		}
		header('Location:/home');

	}

	function logout() {
		unset($_SESSION);
		session_destroy();

		header('Location:/home');
	}

}
