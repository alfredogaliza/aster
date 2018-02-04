<?php

class Perfil extends Model {

	const ID_VOLUNTARIO = 1;
	
	public function __construct($id = null, $read = true){
		parent::__construct("perfil", $id, $read);
	}
	
	public function hasRecurso($recurso_id){
		$perfil_id = $this->get('id');
		$sql = "SELECT * FROM perfil_recurso WHERE perfil_id = '$perfil_id' AND recurso_id = '$recurso_id'";
		Connection::query($sql);
		return Connection::next() || false;
	}
	
	public function updateRecursos($recursos = array()){
		
		$perfil_id = $this->get('id');
		$sql = "DELETE FROM perfil_recurso WHERE perfil_id = '$perfil_id'";
		Connection::query($sql);
		
		$values = array();
		foreach ($recursos as $recurso_id) $values[] .= "('$perfil_id','$recurso_id')";
		$values = implode(", ", $values);		
			
		$sql = "INSERT INTO perfil_recurso(perfil_id, recurso_id) VALUES $values";
		Connection::query($sql);
		
	}
	
	public static function getAll($table="", $filter="TRUE"){
		$perfis = array();
		$ids = array();
	
		$sql = "SELECT id FROM perfil WHERE $filter";
		Connection::query($sql);
	
		while ($row = Connection::next()) $ids[] = $row['id'];
		foreach ($ids as $id) $perfis[] = new self($id);
	
		return $perfis;
	}	

}
