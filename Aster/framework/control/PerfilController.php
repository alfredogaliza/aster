<?php
require_once 'lib/Controller.php';
require_once 'lib/Session.php';
require_once 'model/Perfil.php';

class PerfilController extends Controller {

	public $id       = NULL;
	public $perfil  = NULL;
	
	public function __construct($action){
		parent::__construct("perfil", $action);
		Session::start();	
		
		$this->id = isset($_GET['id'])? $_GET['id'] : NULL;
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
		$id = isset($_POST['id'])? $_POST['id'] : NULL;
		$descricao = isset($_POST['descricao'])? $_POST['descricao'] : "";
		$recursos  = isset($_POST['recurso_id'])? $_POST['recurso_id'] : array(); 
		
		$this->perfil = new Perfil($id);
		$this->perfil->set('descricao', $descricao);
		$this->perfil->update();
		$this->perfil->updateRecursos($recursos);		
		
		Controller::dispatch("admin", "perfil", 0, array("msg"=>"success")) ;
		return false;
	}

	
}