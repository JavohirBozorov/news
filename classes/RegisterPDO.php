<?php

class registerPDO
{
	private $db;

	function __construct() {
		$this->db = new PDO('mysql:host=localhost;dbname=my_db','root', 'root');
	}

	public function registerFunction($name, $email, $pass) {

		if($name == '' || $email == '' || $pass == '') {
			return; 
		}
		$sql = "INSERT INTO users (name, email, pass) VALUES (\"$name\", \"$email\", \"$pass\")";
		$q = $this->db->query($sql);
		$q->setFetchMode(PDO::FETCH_ASSOC);
		header('Location: /login.php');
	}

}