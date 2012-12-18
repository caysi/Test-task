<?php

abstract class DefaultController{

	protected $viewVariables = array();
	protected $viewObject;
	protected $db;

	public function __construct($db, $controller){
		$this->db = $db;
		$model = ucfirst($controller).'Model';
		$this->model = new $model($db, $this->tableName);
		$this->viewVariables['controller'] = $controller;
		$this->viewVariables['title'] = ucfirst($controller);
		$this->viewVariables['viewPath'] = ROOT_PATH.'application/views/';
		$this->viewObject = new View();
	}

	public function render(){
		$this->viewObject->render($this->viewVariables);
	}
}
