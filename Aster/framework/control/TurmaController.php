<?php
require_once 'lib/Controller.php';
require_once 'lib/Session.php';
require_once 'lib/Globals.php';

require_once 'model/Turma.php';
require_once 'model/Turma.php';



class TurmaController extends Controller {
	
	public $id = NULL;
	public $turma = NULL;
	public $msg = NULL;
	
	public function __construct($action){
		parent::__construct("turma", $action);
		Session::start();

		$this->id = isset($_GET['id'])? $_GET['id'] : NULL;
		$this->turma = new Turma($this->id);	
		$this->msg = Globals::get('msg');	
	}
	
	public function actionOptions(){
		$polo_id = Globals::get('polo_id');
		echo "<option value=''>Selecione uma turma...</option>";
		echo Model::getOptions('lista_turma', 'id', 'descricao', Globals::get('turma_id'), "polo_id='$polo_id'");
		return false;
	}

	public function actionCoordenadores(){
		$polo_id = Globals::get('polo_id');
		echo Model::getOptions('usuario', 'id', 'nome', $this->turma->getCoordenadorIds(), "polo_id='$polo_id' AND ativo");
		return false;
	}
	
	public function actionDelete(){
		$this->turma->delete();
		$this->turma->updateStatus();
		return false;
	}
	
	public function actionGravar(){

		$_POST['abertura'] = Globals::postDate('abertura');
		$_POST['fechamento'] = Globals::postDate('fechamento');
		$_POST['inicio'] = Globals::postDate('inicio');
		$_POST['termino'] = Globals::postDate('termino');
		
		$this->turma = Model::load("turma", $_POST);
		$this->turma->update();
		$turma_id = $this->turma->get('id');
	
		$relacionamentos = [
				'turma_turnodia'=>'turnodia_id',
				'coordenador_turma'=>'coordenador_id',
		];
	
		foreach ($relacionamentos as $tabela => $chave){
			$ids = implode("','", Globals::post($tabela,[]));
			foreach(Globals::post($tabela,[]) as $id)
				Connection::query("REPLACE INTO $tabela (turma_id, $chave) VALUES ('$turma_id', '$id')");
			Connection::query("DELETE FROM $tabela WHERE turma_id='$turma_id' AND $chave NOT IN ('$ids')");
		}
		
		$this->turma->updateStatus();
		
		return false;
	}
	
	
	
	public function actionModal(){
		
		$id = $this->id;
		
		$polo_id = $this->turma->get('polo_id', Session::getUsuario()->hasPermission('gerencia', 'global')? '' : Session::getUsuario('polo_id'));
		$polo = $polo_id? "polo_id ='$polo_id'" : "TRUE";
		
		$rows = Model::getAllRows("coordenador_turma", "turma_id='$id'");
		$ids = []; foreach($rows as $row) $ids[] = $row['coordenador_id']; $ids = implode("','", $ids);
				
		$this->setView('modal');
		
		return true;
	}	
	
}