<?php

class View{
	
	/*public function __construct($variables){
		foreach($variables as $key=>$val){
			$this->$key = $val;
		}
	}*/
	
	public function render($variables){
		foreach($variables as $key=>$val){
			$this->$key = $val;
		}

		ob_start();
			//$contentFile = ucfirst($this->tableName);
			//$contentFile .= 'View.php';
			$contentFile = $this->controller.'/main.htm';
		
			require_once($this->viewPath.$contentFile);
			$content = ob_get_contents();
		ob_end_clean();
		
		require_once($this->viewPath.'main.htm');
	}







	public function update(){
		ob_start();
		$contentFile = ucfirst($this->tableName);
		$contentFile .= 'FormView.php';
		require_once($this->pathView.$contentFile);
		$content = ob_get_contents();
		ob_end_clean();
		
		require_once($this->pathView.'MainView.php');
		
	}
	public function json(){
		echo json_encode($this->result);
	}
}
