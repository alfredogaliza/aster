<?php

class Noticia extends Model {

	public function __construct($id = null, $read = true){
		parent::__construct("noticia", $id, $read);
	}	
	
	public static function getAll($table = "", $filter = "TRUE"){		
		$rows = []; $models = []; 
		for (
			Connection::query("SELECT id FROM noticia WHERE $filter");
			$row = Connection::next();
			$rows[] = $row 			
		);		
		foreach ($rows as $row)
			$models[] = new self($row['id']);
		
		return $models;		
	}

}
