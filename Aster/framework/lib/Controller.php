<?php
class Controller {
	
	protected $name   = "";
	protected $view   = "";
	protected $action = "";
	
	public function __construct($name = "default", $action = "default"){
		$this->name = $name;
		$this->action = $action;
		Session::start();
		
		if (self::grantPermission($name, $action) || Session::getVoluntario()->hasPermission($name, $action));
		else self::dispatch("login");
	}
	
	private function grantPermission($controller, $action){
		if ($controller == "login") return true;
		if ($controller == "cadastro") return true;
		if (Session::getVoluntario('id')){
			if ($controller == "acao") return true;
			if ($controller == "home") return true;
			if ($controller == "noticia") return true;
			if ($controller == "mensagem") return true;
			if ($controller == "atribuicao") return true;
			if ($controller == "tarefa") return true;
			if ($controller == "assistido") return true;
			if ($controller == "evento") return true;
			if ($controller == "perfil") return true;
			if ($controller == "relatorio") return true;
			if ($controller == "responsavel") return true;
			if ($controller == "tarefa") return true;
			if ($controller == "voluntario") return true;
		}
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
