<?php

class Controller_404 extends Controller {
	
	function index(){
		$this->view->generate('404_view.php', 'template_view.php');
	}

}
