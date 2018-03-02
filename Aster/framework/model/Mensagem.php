<?php

class Mensagem extends Model {
	
	const STATUS_LIDA = 1;
	const STATUS_NAO_LIDA = 2;
	
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

	public function ownerClass(){
		if ($this->get('remetente_id') == Session::getVoluntario('id')) return "msg alert-success";
		else if ($this->get('destinatario_id') == Session::getVoluntario('id')) return "msg alert-warning";
		else return "msg";
	}
	
	public function getStatus(){
		if ($this->get('data_leitura')) return self::STATUS_LIDA;
		else return self::STATUS_NAO_LIDA;
	}
	
	public function getStatusClass(){
		if ($this->getStatus() == Config::STATUS_MENSAGEM_LIDA) return "bg-info";
		else return "bg-warning";
	}
	
	public function getOrigem($field = false){
		$origem = new Voluntario($this->get('origem_id'));
		return $field? $origem->get($field) : $origem;
	}
	
	public function getConversa(){
		$origem_id = $this->get('remetente_id');
		$destino_id = $this->get('destinatario_id');
		$filter = "(remetente_id = '$origem_id' AND destinatario_id='$destino_id'
		OR remetente_id = '$destino_id' AND destinatario_id='$origem_id') ORDER BY datahora";
		return self::getAll('mensagem', $filter);
	}	
	
	public static function getAll($table = "", $filter = "TRUE"){		
		$rows = []; $models = []; 
		for (
			Connection::query("SELECT id FROM lista_mensagem WHERE $filter");
			$row = Connection::next();
			$rows[] = $row 			
		);		
		foreach ($rows as $row)
			$models[] = new self($row['id']);
		
		return $models;		
	}

}
