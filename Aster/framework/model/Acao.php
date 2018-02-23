<?php

class Acao extends Model {	
	
	public function __construct($id = null, $read = true){
		parent::__construct("acao", $id, $read);
	}
	
	public static function getAll($table="", $filter="TRUE"){
		$models = array();
		$ids = array();
	
		$sql = "SELECT id FROM acao WHERE $filter";
		Connection::query($sql);
	
		while ($row = Connection::next()) $ids[] = $row['id'];
		foreach ($ids as $id) $models[] = new self($id);
	
		return $models;
	}	

}
