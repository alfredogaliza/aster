<?php
class Controller {
	
	protected $name   = "";
	protected $view   = "";
	protected $action = "";
	
	public function __construct($name = "default", $action = "default"){
		$this->name = $name;
		$this->action = $action;
		Session::start();				
	}
	
	public function setView($view){
		$this->view = $view;
	}
	
	public function run(){
		$action = "action".ucfirst($this->action);
		if ($this->$action() && $this->view){
			include "view/{$this->view}.php";
		}
		return true;
	}
	
	public function actionDefault(){
		return false;
	}
	
	public function __call($function, $params){
		throw new Exception("$function not implemented yet!");
	}
	
	public static function route($controller, $action = "default", $id = NULL, $params = array()){
		
		$query = array();
		foreach ($params as $key => $value)	$query[] = "$key=" . urlencode($value);	
		$q = implode("&", $query);
		
		$url  = Config::baseURL();
		$url .= Config::REWRITE? "$controller/$action" : "?controller=$controller&action=$action";				
		$url .= Config::REWRITE? ($id? "/$id" : "")	: ($id? "&id=$id" : "");	
		$url .= Config::REWRITE? ($q? "/?$q" : "")	: ($q? "&q" : "");
			
		return $url;		
	} 
	
	public static function dispatch($controller, $action = "default", $id = NULL, $params=array()){
		$url = self::route($controller, $action, $id, $params);
		header("Location: $url");
		die;
	}
		
}
