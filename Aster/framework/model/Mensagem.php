<?php

class Mensagem extends Model {
	
	protected $remetente = NULL;
	protected $destinatario = NULL;

	public function __construct($id = null, $read = true){
		parent::__construct("mensagem", $id, $read);
	}

	public function getRemetente($field = NULL, $default = NULL){
		if (is_null($this->remetente)) $this->remetente = new Voluntario($this->get('remetente_id'));
		return $field? $this->remetente->get($field, $default) : $this->remetente;
	}
	
	public function getDestinatario($field = NULL, $default = NULL){
		if (is_null($this->destinatario)) $this->destinatario = new Voluntario($this->get('destinatario_id'));
		return $field? $this->destinatario->get($field, $default) : $this->destinatario;
	}	
	
	public static function getAll($table = "", $filter = "TRUE"){		
		$rows = []; $models = []; 
		for (
			Connection::query("SELECT id FROM mensagem WHERE $filter");
			$row = Connection::next();
			$rows[] = $row 			
		);		
		foreach ($rows as $row)
			$models[] = new self($row['id']);
		
		return $models;		
	}

}
