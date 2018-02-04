<?php
require_once 'lib/Controller.php';
require_once 'lib/Session.php';

class RecursoController extends Controller {
	
	public $id = NULL;
	public $recurso = NULL;
	
	public function __construct($action){
		parent::__construct("recurso", $action);
		Session::start();
		$this->id = isset($_GET['id'])? $_GET['id'] : NULL;
		$this->recurso = new Model('recurso', $this->id, true);		
	}
	
	public function actionModal(){
		$this->setView('modal');
		return true;
	}
	
	public function actionDelete(){
		$this->recurso->delete();		
		Controller::dispatch("admin", "recurso", 0, array("msg"=>"success"));
	}
	
	public function actionUp(){

		$ordem = $this->recurso->get('ordem');
		$sql = "SELECT id FROM recurso WHERE ordem <= '$ordem' AND id <> '$id' ORDER BY ordem DESC LIMIT 1";
		Connection::query($sql);
		
		if ($resultado = Connection::next()) {
			$baixo = new Model('recurso', $resultado['id'], true);
			$nova_ordem = $baixo->get('ordem');
			if ($nova_ordem == $ordem) $nova_ordem = $nova_ordem - 1;
			
			$baixo->set('ordem', $ordem);
			$this->recurso->set('ordem', $nova_ordem);
			
			$baixo->update();
			$this->recurso->update();
		}
	
		Controller::dispatch("admin", "recurso");
		return false;
	}

	public function actionDown(){

		$ordem = $this->recurso->get('ordem');
	
		$sql = "SELECT id FROM recurso WHERE ordem >= '$ordem' AND id <> '$id'  ORDER BY ordem ASC LIMIT 1";
		Connection::query($sql);
	
		if ($resultado = Connection::next()) {
			
			$cima = new Model('recurso', $resultado['id'], true);
			$nova_ordem = $cima->get('ordem');
			if ($nova_ordem == $ordem) $nova_ordem = $nova_ordem + 1;
				
			$cima->set('ordem', $ordem);
			$this->recurso->set('ordem', $nova_ordem);
				
			$cima->update();
			$this->recurso->update();
		}
	
		Controller::dispatch("admin", "recurso");
		return false;
	}
	
	
	public function actionGravar(){
		
		if ($_POST['menu_id'] < 0) $_POST['menu_id'] = NULL;
		
		$this->recurso = Model::load("recurso", $_POST);
		$this->recurso->update();
				
		Controller::dispatch("admin", "recurso", 0, array("msg"=>"success")) ;
		return false;
	}

	
}