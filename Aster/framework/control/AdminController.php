<?php

class AdminController extends Controller {
	
	public function __construct($action){		
		parent::__construct("admin", $action);
		Session::start();		
	}
	
	public function __call($functionName, $params){
		preg_match("/^action(.+)$/", $functionName, $matches);
		if ($matches){			
			$module = strtolower($matches[1]);
			$this->setView("$module/admin");
			return true;
		}
		return false;		
	}
		
	
}