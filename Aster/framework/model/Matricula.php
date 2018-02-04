<?php
require_once "lib/Connection.php";

require_once "lib/Model.php";
require_once "model/Polo.php";
require_once "model/Aluno.php";
require_once "model/Turma.php";

class Matricula extends Model {

	public function __construct($id = null, $read = true){
		parent::__construct("matricula", $id, $read);		
	}	
	
	public function getTurma($field = false){
		$turma = new Turma($this->get('turma_id'));
		return $field? $turma->get($field) : $turma;
	}

	public function getAluno($field = false){
		$aluno = new Aluno($this->get('aluno_id'));
		return $field? $aluno->get($field) : $aluno;
	}
	
	public function getPolo($field = false){
		$polo = new Polo($this->getTurma('polo_id'));
		return $field? $polo->get($field) : $polo;
	}
	
	public function updateStatus(){
		parent::updateStatus();
		$this->getAluno()->updateStatus();
		return;
	}
	
	public function delete(){
		$this->set('ativo', 0)->update();
		return;
	}
	
	public static function getAll($table="matricula", $filter="TRUE"){
		$itens = array();
		$ids = array();
	
		$sql = "SELECT id FROM matricula WHERE $filter";
		Connection::query($sql);
	
		while ($row = Connection::next()) $ids[] = $row['id'];
		foreach ($ids as $id) $itens[] = new self($id);
	
		return $itens;
	}	
	
	
}
