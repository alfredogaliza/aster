<?php
require_once 'lib/Controller.php';
require_once 'lib/Session.php';
require_once 'lib/Globals.php';
require_once 'model/Polo.php';


class PoloController extends Controller {
	
	public $id = NULL;
	public $polo = NULL;
	
	public function __construct($action){
		parent::__construct("polo", $action);
		Session::start();
		
		$this->id = Globals::get('id');
		$this->polo = new Polo($this->id);		
	}
	
	public function actionModal(){
		$this->setView('modal');
		return true;
	}
	
	public function actionBlock(){
		$this->polo->set('cadastravel', 0);
		$this->polo->update();
		return false;
	}
	
	public function actionUnblock(){
		$this->polo->set('cadastravel', 1);
		$this->polo->update();
		return false;
	}
	
	public function actionRegioes(){
		$this->setView("regioes");
		return true;
	}	
	
	public function actionDeladdregiao(){
		$polo_id = $this->id;
		$bairro_id  = Globals::get('bairro_id');
		$cidade_id  = Globals::get('cidade_id');
		$acao       = Globals::get('acao', 'add');
		
		if ($bairro_id) {
			$filter = "id = '$bairro_id'";
		} else if ($cidade_id){
			$filter = "cidade_id = '$cidade_id'";			
		} else {
			$filter = "TRUE";
		}		
		
		if ($acao == 'add'){
			$sql = "INSERT INTO regiao (polo_id, bairro_id)
					SELECT '$polo_id' as polo_id, id as bairro_id
					FROM bairro WHERE $filter";
		} else {
			$sql = "DELETE FROM regiao WHERE polo_id = '$polo_id' AND
						bairro_id IN (SELECT id FROM bairro WHERE $filter)";			
		}
		Connection::query($sql, false);
		
		$this->setView("regioes");
		return true;
	}
	
	public function actionDelregiao(){
		$polo_id = $this->id;
		$bairro_id  = Globals::get('bairro_id');
	
		$sql = "DELETE FROM regiao WHERE polo_id = '$polo_id' AND bairro_id = '$bairro_id'";
		Connection::query($sql);
	
		$this->setView("regioes");
		return true;
	}	

	
	public function actionDelete(){
		$this->polo->set('ativo', 0);
		$this->polo->update();
		Controller::dispatch("admin", "polo", 0, array("msg"=>"success"));
	}
	
	public function actionGravar(){
		$_POST['comandante_id'] = Globals::post('comandante_id')? Globals::post('comandante_id') : NULL;  
		$this->polo  = Model::load("polo", $_POST);
		$this->polo->update();
		Controller::dispatch("admin", "polo", 0, array("msg"=>"success")) ;
		return false;
	}
	
}