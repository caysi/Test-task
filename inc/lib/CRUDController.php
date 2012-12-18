<?php

class CRUDController extends DefaultController{

	public function read($params){
		if(empty($params)){
			$result = $this->model->findAllOrderById($this->fields);
		}
		else{
			$args = $this->condition($params);
			$result = $this->model->find($args['condition'], $args['params']);
		}
		$this->viewVariables['result'] = $result;
		
	}	// read






	// this function not use in this task
	public function update($params){
		//
	}	// update

	public function create($params){
		//
	}	// create
	public function delete($params){
		//
	}	// delete
	

	protected function jsonOrHtml(){
		// AJAX
	}

	// this function use in update, create, delete
	protected function condition($params){
		$args['condition'] = '';
		$first = TRUE;
		foreach($params as $field=>$val){
			if(!$first){
				$args['condition'] .= ' AND ';
			}
			$args['condition'] .= $field.'=?';
			$args['params'][] = $val;
			$first = FALSE;
		}
		return $args;
	}
	protected function location(){
		header('Location: '.ROOT_URL);
	}
	protected function checkFields(){
		$assocArray = array();
		foreach($this->fields as $field){
			if($this->request->$field){
				$value = $this->request->$field;
				$assocArray[$field] = $value;
			}
			else{
				throw new LibException('Не задано поле: '.$field);
			}
		}
		return $assocArray;
	}
}
