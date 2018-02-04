<?php

class LoginController extends Controller {
	
	public $msg   = "";
	
	public function __construct($action){
		parent::__construct("login", $action);
		Session::start();	
		
		$this->msg = Globals::get('msg');
	}
	
	public function actionDefault(){
		return $this->actionLogoff();
	}

	public function actionLogoff(){
		Session::destroy();		
		$this->setView("loginForm");
		return true;	
	}

	public function actionLogon(){
		
		$email = Globals::post('email');
		$senha = strtoupper(md5(Globals::post('senha')));
		
		
		if ($usuario = Usuario::logon($email, $senha)){
			Session::set('usuario', $usuario);
			Controller::dispatch("home");
			return false;
		} else {			
			$this->msg = "fail";
			$this->setView("loginForm");
			return true;
		}	
		
	}
	
}