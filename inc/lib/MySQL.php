<?php

class MySQL implements DbConnector{
	public function __construct($host, $user, $pass, $name){
		if(!mysql_connect($host, $user, $pass))
			throw new LibException('Не удалось подключится к серверу: '.$host);
		if(!mysql_select_db($name))
			throw new LibException('Не удалось подключится к базе: '.$name);
		
	}
	public function __destruct() {
		return mysql_close();
	}
	
	private function execute_mysql_query($sql){
		$result = mysql_query($sql);
		if(mysql_error()){
			throw new LibException("MySQL Error: ".mysql_error());
		}
		return $result; 
	}
	
	public function execute($sql){
		$this->execute_mysql_query($sql);
		return mysql_affected_rows(); // the number of affected rows
	}
	public function query($sql){
		$query = $this->execute_mysql_query($sql);
		$rows = array();
		while($row = mysql_fetch_assoc($query)) {
			$rows[] = $row;
		}
		return $rows;
	}
}
