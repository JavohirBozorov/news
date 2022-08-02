<?php

class EmptyElement {

    function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=my_db','root', 'root');
	}
    
    function filterInput($POST) {
        $arr = array();
        $arr['fields'] = array();
        $arr['errors'] = array();

        if(empty($POST['name'])) {
            $arr['errors']['name'] = 'Name cannot be empty';
        } else {
            $arr['fields']['name'] = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
        if(empty($POST['email'])) {
            $arr['errors']['email'] = 'Email cannot be empty';
        } else {
            $arr['fields']['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
        if(empty($POST['password'])) {
            $arr['errors']['password'] = 'Password cannot be empty';
        } else {
            $arr['fields']['password'] = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
        
        return $arr;

    }
}