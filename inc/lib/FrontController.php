<?php

class FrontController{
	protected $db;
	
	public function __construct($db){
		$this->db = $db;
	}
	
	public function dispatch($request){
		$contName = ucfirst($request->controller);
		$contName .= 'Controller';
		$controller = new $contName($this->db, $request->controller);
		
		$action = $request->action;
		$controller->$action($request->params);
		$controller->render();
	}
}
