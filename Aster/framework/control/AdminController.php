<?php

class AdminController extends Controller {
	
	public $msg   = "";

	
	public function __construct($action){
		
		parent::__construct("admin", $action);
		Session::start();
		
		$this->msg = Globals::get('msg');
		
	}
		
	
	public function actionBairro(){
		
		$cidade_id = Globals::get('cidade_id');
		$nome = Globals::get('nome');
		
		$cidade = $cidade_id? "cidade_id = '$cidade_id'" : "TRUE";
		$filter = "nome LIKE '%$nome%' AND $cidade ORDER BY cidade_nome, nome";
				
		$this->bairros = Model::getAll("lista_bairro", $filter);
		$this->setView("bairro");
		return true;
	}	
	
	public function actionPolo(){
		$this->polos = Polo::getAll('polo', 'ativo');		
		$this->setView("polo");
		return true;
	}
	
	public function actionPerfil(){
		$this->perfis = Perfil::getAll();				
		$this->setView("perfil");
		return true;
	}
	
	public function actionRecurso(){
		$this->recursos = Recurso::getAll("", "TRUE ORDER by menu_id, ordem");				
		$this->setView("recurso");
		return true;
	}
	
}