<?php

class Responsavel extends Model {	
	
	protected $assistido = NULL;
	
	public function __construct($id = null, $read = true){
		parent::__construct("responsavel", $id, $read);
	}
	
	public function getAssistido(){
		if (is_null($this->assistido)){
			$this->assistido = new Assistido($this->get('assistido_id'));
		}
		return $this->assistido;
	}
	
	public static function getAll($table="", $filter="TRUE"){
		$models = array();
		$ids = array();
	
		$sql = "SELECT id FROM responsavel WHERE $filter";
		Connection::query($sql);
	
		while ($row = Connection::next()) $ids[] = $row['id'];
		foreach ($ids as $id) $models[] = new self($id);
	
		return $models;
	}	

}
