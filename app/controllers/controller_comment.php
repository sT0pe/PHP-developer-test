<?php

class Controller_Comment extends Controller {

	function __construct() {
		parent::__construct();
		$this->model = new Model_Comment();
	}


	function add(){

		$data['error'] = false;

		if( isset($_POST['text']) && trim($_POST['text']) == '' || !isset($_POST['text']) ) {
			$data['error'] = 'Коментарі не можуть бути порожніми!';
			echo json_encode($data);
			exit();
		}

		if( isset($_POST['guest']) && strlen(trim($_POST['guest'])) < 2 ) {
			$data['error'] = 'Ім\'я повинне мати не менше двох символів!';
			echo json_encode($data);
			exit();
		}

		$text = htmlspecialchars(trim($_POST['text']), ENT_QUOTES);

		if( isset($_POST['id_parent']) && $_POST['id_parent'] != 0 ) {

			if( isset($_POST['guest']) ){
				$guest = htmlspecialchars(trim($_POST['guest']), ENT_QUOTES);
				$this->model->add_comment( $_POST['category_id'], $text, $_POST['id_parent'], NULL, $guest );
			} else {
				$this->model->add_comment( $_POST['category_id'], $text, $_POST['id_parent'], $_POST['id_user'], NULL);
			}

		} else if( isset($_POST['id_comment']) && $_POST['id_comment'] != 0 ){

			$this->model->edit_comment( $_POST['id_comment'], $text );

		} else {

			if( isset($_POST['guest']) ){
				$guest = htmlspecialchars(trim($_POST['guest']), ENT_QUOTES);
				$this->model->add_comment( $_POST['category_id'], $text, 0, NULL, $guest );
			} else {
				$this->model->add_comment( $_POST['category_id'], $text, 0, $_POST['id_user'], NULL);
			}
		}

		$data['comments'] = $this->model->get_comments( $_POST['category_id'] );
		$data['quantity'] = $this->model->quantity( $_POST['category_id'] );

	    echo json_encode($data);
		exit();
	}





	function delete() {

		if( isset($_POST['id']) ){
			$this->model->delete_comment( $_POST['id'] );
		}

		$data['comments'] = $this->model->get_comments( $_POST['category'] );
		$data['quantity'] = $this->model->quantity( $_POST['category'] );

		echo json_encode($data);
		exit();
	}



	function vote(){

		$user_id = $_POST['data'][0];
		$comment_id = $_POST['data'][1];
		$comment_author = $_POST['data'][2];
		$type = ($_POST['data'][3] == 'vote-up') ? 1 : 0;

		$data['error'] = false;

		if( $user_id == 0 ){
			$data['error'] = 'Ви маєте авторизуватись щоб оцінити повідомлення!';
			echo json_encode($data);
			exit();
		}

		if( $user_id == $comment_author ){
			$data['error'] = 'Ви не можете оцінювати власні повідомлення!';
			echo json_encode($data);
			exit();
		}

		$this->model->vote($user_id, $comment_id, $type);

		$data['rating'] = $this->model->rating($comment_id);

		echo json_encode($data);
		exit();
	}

}