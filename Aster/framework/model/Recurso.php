<?php
require_once "lib/Connection.php";
require_once "lib/Model.php";

class Recurso extends Model {

	public function __construct($id = null, $read = true){
		parent::__construct("recurso", $id, $read);
	}
	
	public function getMenu(){
		return new Model("menu", $this->get('menu_id'), true);
	}
	
	public static function getAll($table = "", $filter="TRUE"){
		$ids = array();
		$recursos = array();
		
		$sql = "SELECT id FROM recurso WHERE $filter";
		
		Connection::query($sql);
		
		while ($row = Connection::next()) $ids[] = $row['id'];		
		foreach ($ids as $id) $recursos[] = new self($id);

		return $recursos;
	} 

}
