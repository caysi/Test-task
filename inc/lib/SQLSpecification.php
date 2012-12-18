<?php

class SQLSpecification{
	private $db;
	private $sql;
	private $tables = array();
	const PARAM_NEEDLE = '?';

	public function __construct(DbConnector $db){
		$this->db = $db;
	}
	// old      ('table','field1',field2,....) OR ('table',array('field1',field2,....))
	// possibly ('table', array('field1', 'field2', 'ru_n'=>'name', 'email'=>'e', 'field4', .....))
	// now      ('table', array('field1', 'field2', 'AS'=array('ru_n'=>'name', 'email'=>'e'), 'field4', .....))
	public function select($table, $fields = '*'){
		if(is_array($fields)){
			if(isset($fields['AS'])){
				$str = '';
				foreach($fields['AS'] as $field=>$as){ // move to wrap // if need move to function
					$str .= $field.''.$as.',';
				}
				$fields['AS'] = $str;
				unset($str);
			}
			$fields = $this->wrapArray($fields, FALSE);
			$fields = implode(',',$fields);
		}

		$this->sql = "SELECT $fields FROM $table";
		$this->tables[1] = $table;
		return $this;
	}
	//('post',array('Theme'=>'Hello','Text'=>,'World\nGGGGGg','UserId'=>1))
	public function insert($table, $params){
		foreach($params as $key=>$val){
			$params[0][] = $this->wrap($key, FALSE);
			$params[1][] = $this->wrap($val);
		}
		$params[0] = implode(',',$params[0]);
		$params[1] = implode(',',$params[1]);
		$this->sql = "INSERT INTO $table ($params[0]) VALUES($params[1])";
		return $this;
	}
	// ('table')
	public function delete($table){
		$this->sql = "DELETE FROM $table";
		return $this;
	}
	// ('table', array('name'=>'vasy', 'age'=>18, ......))
	public function update($table, $array){
		$set = array();
		foreach($array as $key=>$val){
			$set[] = $key.'='.$this->wrap($val);
		}
		$value = implode(',',$set);
		$this->sql = "UPDATE $table SET $value";
		return $this;
	}

	// ('name=?', array('vasya'))
	// ('name=? AND id<=? OR age>? .........', array('vasya', '5', '18', ........))
	public function where($conditions){
		$array = $this->clearArguments(func_get_args());
		$this->sql .= ' WHERE '.$this->substitute($conditions, $array);
		return $this;
	}
	// ('name', 1)
	public function order($field, $desc = FALSE){
		$this->sql .= ' ORDER BY '.$field;
		if($desc){
			$this->sql .= ' DESC';
		}
		return $this;
	}
	// 
	// public function group(){}
	//
	public function join($table, $conditionsArray, $join = 'INNER'){  // conditions
		$this->tables[] = $table;
		$this->sql .= ' '.strtoupper($join).' JOIN '.$table.' ON ';
		$first = TRUE;
		$cnt=count($conditionsArray);
		
		for($i=0; $i<$cnt; $i++){
			if(!$first){
				$this->sql .= ' AND ';
			}
			$this->sql .= $this->tables[$conditionsArray[$i]].'.';
			$i++;
			$this->sql .= $conditionsArray[$i].'=';
			$i++;
			$this->sql .= $this->tables[$conditionsArray[$i]].'.';
			$i++;
			$this->sql .= $conditionsArray[$i];
			$first = FALSE;
		}
		return $this;
	}
	
	private function substitute($conditions, $params){
		$cnt = 0;
		while(($pos = strpos($conditions, self::PARAM_NEEDLE)) > -1){
			$c = substr($conditions, 0, $pos);
			$c .= $this->wrap($params[$cnt]);
			$cnt++;
			$conditions = $c.substr($conditions, ($pos + strlen(self::PARAM_NEEDLE)));
		}
		return $conditions;
	}
	private function clearArguments($array, $quantity = 1){
		$array = array_slice($array, $quantity);
		if(is_array($array[0])){
			$array = $array[0];
		}
		/*if($wrap){
			foreach($array as &$val){
				$val = $this->wrap($val, false);
			}
		}*/
		return $array;
	}
	private function wrapArray($array, $val = TRUE){
		foreach($array as $key=>&$data){
			if($key == 'AS') continue;
			$data = $this->wrap($data, $val);
		}
		return $array;
	}
	// обтягивает кавычками и ` если надо
	private function wrap($data, $val = TRUE){
		if(is_string($data)){
			$data = addslashes($data);
			if($val){
				$data = "'$data'";
			}
			else{
				if(strpos($data,' ')){
					$data = "`$data`";
				}
			}
		}
		if(is_bool($data)){
			$data = $data ? 'true' : 'false';
		}
		return $data;
	}
	
	public function execute(){
		return $this->db->execute($this->sql);
	}
	public function query(){
		return $this->db->query($this->sql);
	}
}
