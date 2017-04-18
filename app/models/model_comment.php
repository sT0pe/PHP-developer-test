<?php

class Model_Comment extends Model {

	public function __construct() {
		parent::__construct();
	}



	public function quantity( $cat_id ){

		$sql = $this->db->prepare("SELECT id FROM comments WHERE category_id = ? AND status = 1");
		$sql->execute([$cat_id]);

		return count($sql->fetchAll(PDO::FETCH_ASSOC));
	}



	public function get_comments( $cat_id ) {

		$sql = $this->db->prepare("SELECT comments.*, users.name, users.image FROM comments LEFT JOIN users 
											 ON comments.id_user = users.id WHERE category_id = ? ORDER BY comments.created_at DESC ");
		$sql->execute([$cat_id]);

		$vote_up = $this->db->prepare('SELECT id FROM ratings WHERE rating = 1 AND id_comment = ?');
		$vote_down = $this->db->prepare('SELECT id FROM ratings WHERE rating = 0 AND id_comment = ?');

		$_comments = array();
		$ratings = array();
		foreach ($sql->fetchAll(PDO::FETCH_ASSOC) as $row){
			$_comments[$row['id']] = $row;

			$vote_up->execute([$row['id']]);
			$vote_down->execute([$row['id']]);
			$ratings[$row['id']] = $vote_up->rowCount() - $vote_down->rowCount();
		}


		function build_tree( $data ){

			$tree = array();

			foreach($data as $id => &$row){
				if($row['id_parent'] == 0){
					$tree[$id] = &$row;
				} else {
					$data[$row['id_parent']]['children'][$id] = &$row;
				}
			}
			return $tree;
		}

		$comments = build_tree( $_comments );
		unset( $_comments );

		function getCommentsTemplate( $comments, $ratings ){

			$html = '';
			foreach( $comments as $comment ){
				ob_start();
				include 'app/views/comments_template.php';
				$html .= ob_get_clean();
			}
			return $html;
		}

		$comments = getCommentsTemplate( $comments, $ratings );

		return $comments;
	}



	public function add_comment( $cat, $text, $id_parent, $id_user, $guest ){

		$sql = $this->db->prepare("INSERT INTO comments (category_id, text, id_parent, id_user, guest) VALUES (?, ?, ?, ?, ?)");
		$sql->execute([$cat, $text, $id_parent, $id_user, $guest]);

		return true;
	}



	public function edit_comment( $id, $text ){

		$sql = $this->db->prepare("UPDATE comments SET text = ? WHERE id = ?");
		$sql->execute([$text, $id]);

		return true;
	}



	public function delete_comment( $id ){
		$query = $this->db->prepare('SELECT id FROM comments WHERE id_parent = ?');
		$query->execute([$id]);

		if( count($query->fetchall()) != 0 ) {
			$sql = $this->db->prepare("UPDATE comments SET status = 0 WHERE id = ?");
			$sql->execute([$id]);
		} else {
			$sql = $this->db->prepare("DELETE FROM comments WHERE id = ?");
			$sql->execute([$id]);
		}

		return true;
	}


	public function vote($user_id, $comment_id, $type){

		$query = $this->db->prepare('SELECT id, rating FROM ratings WHERE id_user = ? AND id_comment = ?');
		$query->execute([$user_id, $comment_id]);
		$result = $query->fetchAll(PDO::FETCH_ASSOC);

		if( empty($result) ){

			$sql = $this->db->prepare("INSERT INTO ratings (rating, id_user, id_comment) VALUES (?, ?, ?)");
			$sql->execute([$type, $user_id, $comment_id]);

		} else {

			if( $type == $result[0]['rating'] ){

				$sql = $this->db->prepare("DELETE FROM ratings WHERE id = ?");
				$sql->execute([$result[0]['id']]);

			} else {

				$sql = $this->db->prepare("UPDATE ratings SET rating = ? WHERE id = ?");
				$sql->execute([$type, $result[0]['id']]);

			}

		}

		return true;
	}

	public function rating( $id ){

		$vote_up = $this->db->prepare('SELECT id FROM ratings WHERE rating = 1 AND id_comment = ?');
		$vote_down = $this->db->prepare('SELECT id FROM ratings WHERE rating = 0 AND id_comment = ?');
		$vote_up->execute([$id]);
		$vote_down->execute([$id]);

		return $vote_up->rowCount() - $vote_down->rowCount();
	}

}