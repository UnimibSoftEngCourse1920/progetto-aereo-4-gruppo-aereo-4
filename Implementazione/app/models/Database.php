<?php

class Database {

	private $connection;
	
	public function connect() {
		$this->connection = new PDO('mysql:host=127.0.0.1;dbname=test;charset=utf8', 'root', '');
	}
	
	//Metodo da completare
	public function query($query) {
		if(!$this->connection instanceof PDO) {
			$this->connect();
		}
		$statement = explode(' ', trim($query))[0];
		switch ($statement) {
			case "SELECT":
				return $this->connection->query($query)->fetchAll();
			case "INSERT":
				break;
			case "UPDATE":
				break;
		}
	}
	
}