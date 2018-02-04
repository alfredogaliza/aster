<?php
require_once 'lib/Controller.php';
require_once 'lib/Session.php';
require_once 'lib/Globals.php';

require_once 'model/Matricula.php';



class MatriculaController extends Controller {
	
	public $id = NULL;
	public $matricula = NULL;
	public $msg = NULL;
	
	public function __construct($action){
		parent::__construct("matricula", $action);
		Session::start();

		$this->id = isset($_GET['id'])? $_GET['id'] : NULL;
		$this->matricula = new Matricula($this->id);	
		$this->msg = Globals::get('msg');	
	}

	public function actionOptionsTurmas(){
		$status = Config::STATUS_TURMA_ABERTA;
		$polo_id = Globals::get('polo_id');
		$sql = "SELECT id, CONCAT(descricao, ' (Vagas: ',vagas-matriculas,')') as descricao FROM lista_turma WHERE status ='$status' AND polo_id='$polo_id' AND vagas > matriculas";
		echo Model::getOptionsSQL($sql, Globals::get('turma_id'), "Selecione uma turma...");
		return false;
	}
	
	public function actionDelete(){
		$this->matricula->delete();
		$this->matricula->updateStatus();
		return false;
	}
	
	public function actionGravar(){

		$_POST['inclusao'] = Globals::post('inclusao')? Globals::post('inclusao') : "NOW()";
		$_POST['data_exclusao'] = Globals::post('data_exclusao')? Globals::post('data_exclusao') : NULL;
		$this->matricula = Model::load("matricula", $_POST);
		$this->matricula->update();
		$matricula_id = $this->matricula->get('id');	
		
		$this->matricula->updateStatus();
		
		return false;
	}
	
	
	
	public function actionModal(){		
		$this->setView('modal');		
		return true;
	}	
	
}