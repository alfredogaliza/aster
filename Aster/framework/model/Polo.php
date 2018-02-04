<?php
require_once "lib/Connection.php";
require_once "lib/Model.php";

require_once 'model/Usuario.php';

class Polo extends Model {

	public function __construct($id = null, $read = true){
		parent::__construct("polo", $id, $read);
	}
	
	public function getComandante($field = NULL){
		
		$usuario = new Usuario($this->get('comandante_id'));
		
		if ($usuario->get('id'))
			return $field? $usuario->get($field) : $usuario;
		else
			return $field? NULL : new Usuario();

	}
	
	public function getTurmasAbertas(){	
		
		$id = $this->get('id');
		$status = Config::STATUS_TURMA_ABERTA;
		$rows = Model::getAllRowsSQL("SELECT * FROM lista_turma WHERE polo_id='$id' AND status ='$status'");
		
		return $rows;
	}
	
	public function getCidade($field = NULL){
	
		$cidade = new Model('cidade', $this->get('cidade_id'), true);
	
		if ($cidade->get('id'))
			return $field? $cidade->get($field) : $usuario;
			else
				return $field? NULL : new Model('cidade');
	
	}
	
	public static function getAll($table="polo", $filter="TRUE"){
		$polos = array();
		$ids = array();
		
		$sql = "SELECT id FROM polo WHERE $filter";
		Connection::query($sql);
		
		while ($row = Connection::next()) $ids[] = $row['id'];
		foreach ($ids as $id) $polos[] = new self($id);

		return $polos;
	}

}
