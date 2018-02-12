<?php

class PerfilController extends Controller {

	public $id       = NULL;
	public $perfil  = NULL;
	
	public function __construct($action){
		parent::__construct("perfil", $action);
		Session::start();	
		
		$this->id = Globals::get('id');
		$this->perfil = new Perfil($this->id);		
	}
	
	public function actionModal(){
		$this->setView('modal');
		return true;
	}
	
	public function actionDelete(){
		$this->perfil->delete();
		Controller::dispatch("admin", "perfil", 0, array("msg"=>"success"));
	}
	
	public function actionGravar(){
		$id          = Globals::post('id');
		$descricao   = Globals::post('descricao');
		$recurso_ids = Globals::post('recurso_id', []); 
		
		$this->perfil = new Perfil($id);
		$this->perfil->set('descricao', $descricao);
		$this->perfil->update();
		$this->perfil->updateRecursos($recurso_ids);		
		
		Controller::dispatch("admin", "perfil", 0, array("msg"=>"success")) ;
		return false;
	}

	
}