<?php

class registerPDO
{
	private $db;

	function __construct() {
		$this->db = new PDO('mysql:host=localhost;dbname=my_db','root', 'root');
	}

	public function registerFunction($name, $email, $pass) {

		$hashedPwd = password_hash($pass, PASSWORD_BCRYPT);

		if($name == '' || $email == '' || $hashedPwd == '') {
			return; 
		}
		$sql = "INSERT INTO users (name, email, pass) VALUES (\"$name\", \"$email\", \"$hashedPwd\")";
		$q = $this->db->query($sql);
		$q->setFetchMode(PDO::FETCH_ASSOC);
		header('Location: /login.php');
	}

}