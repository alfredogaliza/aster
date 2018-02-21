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
		$this->setView("login/form");
		return true;	
	}

	public function actionLogon(){
		
		$email = Globals::post('email');
		$senha = strtoupper(md5(Globals::post('senha')));
		
		
		if ($voluntario = Voluntario::logon($email, $senha)){
			Session::setVoluntario($voluntario);
			Controller::dispatch("home");
			return false;
		} else {			
			$this->msg = "fail";
			$this->setView("login/form");
			return true;
		}	
		
	}
	
}