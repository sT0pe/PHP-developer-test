<?php

class Model_Category extends Model {

	public function __construct() {
		parent::__construct();
	}

	public function get_categories() {

		$sql = $this->db->prepare("SELECT id, category FROM categories");
		$sql->execute();

		return  $sql->fetchAll(PDO::FETCH_ASSOC);
	}

}
