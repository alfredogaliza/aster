<?php
require_once "lib/Connection.php";

require_once "lib/Model.php";
require_once "model/Polo.php";

class Turma extends Model {

	public function __construct($id = null, $read = true){
		parent::__construct("turma", $id, $read);		
	}	
	
	public function getPolo($field = false){
		$polo = new Polo($this->get('polo_id'));
		return $field? $polo->get($field) : $polo;
	}
	
	
	public function getTurnoDiaIds(){
		$id = $this->get('id');
		$ids = [];
		$sql = "SELECT turnodia_id FROM turma_turnodia WHERE turma_id = '$id'";
		
		Connection::query($sql);
		while ($row = Connection::next()) $ids[] = $row['turnodia_id'];
		
		return $ids;
	}
	
	public function getCoordenadorIds(){
		$id = $this->get('id');
		$ids = [];
		$sql = "SELECT	
					coordenador_id
				FROM coordenador_turma ct
					LEFT JOIN usuario u on u.id = ct.coordenador_id AND u.ativo
				WHERE turma_id = '$id'";
	
		Connection::query($sql);
		while ($row = Connection::next()) $ids[] = $row['coordenador_id'];
	
		return $ids;
	}
	
	public function getMatriculas(){
		
		$itens = [];
		$id = $this->get('id');		
		$rows = Model::getAllRowsSQL("SELECT id FROM matricula WHERE turma_id='$id'");
		
		foreach ($rows as $row) $itens[] = new Matricula($row['id']);
		
		return $itens;
	}
	
	public function updateStatus(){
		parent::updateStatus();
		foreach($this->getMatriculas() as $matricula) $matricula->updateStatus();
		return;
	}
	
	public function delete(){
		$this->set('ativo', 0)->update();
		foreach($this->getMatriculas() as $matricula) $matricula->delete();
		return;
	}
	
	public static function getAll($table="turma", $filter="TRUE"){
		$itens = array();
		$ids = array();
	
		$sql = "SELECT id FROM turma WHERE $filter";
		Connection::query($sql);
	
		while ($row = Connection::next()) $ids[] = $row['id'];
		foreach ($ids as $id) $itens[] = new self($id);
	
		return $itens;
	}	
	
	
}
