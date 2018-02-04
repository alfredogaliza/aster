<?php
require_once 'lib/Controller.php';
require_once 'lib/Session.php';
require_once 'lib/Model.php';
require_once 'lib/Globals.php';

class BairroController extends Controller {
	
	public $id       = NULL;
	public $bairro  = NULL;
	public $bairros = array();
	
	public function __construct($action){
		parent::__construct("bairro", $action);
		Session::start();
		
		$this->id = Globals::get('id');
		$this->bairro = new Model("bairro", $this->id, true);
	}
	
	public function actionModal(){		
		$this->setView('modal');
		return true;
	}
	
	public function actionDelete(){
		$this->bairro->delete();		
		Controller::dispatch("admin", "bairro", 0, array("msg"=>"success"));
	}
	
	public function actionGravar(){		
		$bairro = Model::load("bairro", $_POST);
		$bairro->update();
		return false;
	}

	
}