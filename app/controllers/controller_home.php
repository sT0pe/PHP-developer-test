<?php
include 'app/models/model_category.php';
include 'app/models/model_comment.php';

class Controller_Home extends Controller {

	function index(){

		$CategoryObj = new Model_Category();
		$categories = $CategoryObj->get_categories();

		$commentsObj = new Model_Comment();

		$cat_id = $categories[0]['id'];
		$comments =  $commentsObj->get_comments($cat_id);
		$quantity = $commentsObj->quantity($cat_id);

		$this->view->generate('home_view.php', 'template_view.php', [
			'cat_id'     => $cat_id,
			'categories' => $categories,
			'comments'   => $comments,
			'quantity'   => $quantity
		]);


		unset($_SESSION['errors']);
		unset($_SESSION['success']);
	}

	function tab(){

		$commentsObj = new Model_Comment();
		if( isset($_POST['cat_id']) ){
			$data['category'] = $_POST['cat_id'];
			$data['comments'] = $commentsObj->get_comments($data['category']);
			$data['quantity'] = $commentsObj->quantity($data['category']);
		} else {
			$data['error'] = 'Помилка!';
		}

		echo json_encode($data);
		exit();
	}

}