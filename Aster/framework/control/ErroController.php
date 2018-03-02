<?php

class ErroController extends Controller {
	
	public function __construct($action){		
		parent::__construct("erro", $action);
		Session::start();		
	}
	
	public function actionDefault(){
		$this->setView('erro/modal');
		return true;
	}
		
	
}