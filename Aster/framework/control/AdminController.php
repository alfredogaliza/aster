<?php

class AdminController extends Controller {
	
	public function __construct($action){		
		parent::__construct("admin", $action);
		Session::start();		
	}
	
	public function actionVoluntario(){
		$this->setView("listVoluntario");
		return true;
	}
	
	public function actionAssistido(){
		$this->setView("listAssistido");
		return true;
	}
	
	public function actionResponsavel(){
		$this->setView("listResponsavel");
		return true;
	}
	
	public function actionAcao(){
		$this->setView("listAcao");
		return true;
	}
	
	public function actionEvento(){
		$this->setView("listEvento");
		return true;
	}
	
	public function actionTarefa(){
		$this->setView("listTarefa");
		return true;
	}
	
	public function actionPerfil(){
		$this->setView("listPerfil");
		return true;
	}
	
	public function actionNoticia(){
		$this->setView("listNoticia");
		return true;
	}
	
	public function actionRelatorio(){
		$this->setView("listRelatorio");
		return true;
	}
		
	
}