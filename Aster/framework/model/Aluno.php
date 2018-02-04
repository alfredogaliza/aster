<?php
require_once "lib/Connection.php";

require_once "lib/Model.php";
require_once "model/Polo.php";

class Aluno extends Model {

	public function __construct($id = null, $read = true){
		parent::__construct("aluno", $id, $read);		
	}	
	
	public function getPolo($field = false){
		$polo = new Polo($this->get('polo_id'));
		return $field? $polo->get($field) : $polo;
	}
	
	public function getAtividadeIds(){
		$id = $this->get('id');
		$ids = [];
		$sql = "SELECT atividade_id FROM aluno_atividade WHERE aluno_id = '$id'";
		Connection::query($sql);
		while ($row = Connection::next()) $ids[] = $row['atividade_id'];
		
		return $ids;
	}
	
	public function getMatriculas(){
	
		$itens = [];
		$id = $this->get('id');
		$rows = Model::getAllRowsSQL("SELECT id FROM matricula WHERE aluno_id='$id'");
	
		foreach ($rows as $row) $itens[] = new Matricula($row['id']);
	
		return $itens;
	}
	
	public function delete(){
		$this->set('ativo', 0)->update();
		foreach($this->getMatriculas() as $matricula) $matricula->delete();
		return;
	}
	
	public function getSaudeIds(){
		$id = $this->get('id');
		$ids = [];
		$sql = "SELECT saude_id FROM aluno_saude WHERE aluno_id = '$id'";
		Connection::query($sql);
		while ($row = Connection::next()) $ids[] = $row['saude_id'];
	
		return $ids;
	}
	
	public function getDisciplinaFacilidadeIds(){
		$id = $this->get('id');
		$ids = [];
		$sql = "SELECT disciplina_id FROM disciplina_facilidade WHERE aluno_id = '$id'";
		Connection::query($sql);
		while ($row = Connection::next()) $ids[] = $row['disciplina_id'];
	
		return $ids;
	}
	
	public function getDisciplinaDificuldadeIds(){
		$id = $this->get('id');
		$ids = [];
		$sql = "SELECT disciplina_id FROM disciplina_dificuldade WHERE aluno_id = '$id'";
		Connection::query($sql);
		while ($row = Connection::next()) $ids[] = $row['disciplina_id'];
	
		return $ids;
	}
	
	public function getDisciplinaDependenciaIds(){
		$id = $this->get('id');
		$ids = [];
		$sql = "SELECT disciplina_id FROM disciplina_dependencia WHERE aluno_id = '$id'";
		Connection::query($sql);
		while ($row = Connection::next()) $ids[] = $row['disciplina_id'];
	
		return $ids;
	}
	
	public function getInfraestruturaIds(){
		$id = $this->get('id');
		$ids = [];
		$sql = "SELECT infraestrutura_id FROM aluno_infraestrutura WHERE aluno_id = '$id'";
		Connection::query($sql);
		while ($row = Connection::next()) $ids[] = $row['infraestrutura_id'];
	
		return $ids;
	}
	
	
	public static function getAll($table="aluno", $filter="TRUE"){
		$alunos = array();
		$ids = array();
	
		$sql = "SELECT id FROM aluno WHERE $filter";
		Connection::query($sql);
	
		while ($row = Connection::next()) $ids[] = $row['id'];
		foreach ($ids as $id) $alunos[] = new self($id);
	
		return $alunos;
	}	
	
	
}
