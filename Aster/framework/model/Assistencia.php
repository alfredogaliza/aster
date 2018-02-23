<?php

class Assistencia extends Model {
	
	const STATUS_ABERTA = 1;
	const STATUS_CONCLUIDA = 2;
	
	protected $assistido = NULL;
	
	public function __construct($id = null, $read = true){
		parent::__construct("assistencia", $id, $read);
	}	
	
	public function getStatus(){
		if ($this->get('concluida'))
			return self::STATUS_CONCLUIDA;
		else
			return self::STATUS_ABERTA;	
	}
	
	public function getStatusClass(){
		$classes = [
			self::STATUS_ABERTA => "bg-warning",
			self::STATUS_CONCLUIDA => "bg-success"
		];		
		return $classes[$this->getStatus()];
	}
	
	public function getStatusPanelClass(){
		$classes = [
				self::STATUS_ABERTA => "panel-warning",
				self::STATUS_CONCLUIDA => "panel-success"
		];
		return $classes[$this->getStatus()];
	}	
	
	public function getAssistido($field = null, $default = null){
		if (is_null($this->assistido)){
			$id = $this->get('assistido_id');
			$this->assistido = new Assistido($id);
		}
		
		return $field? $this->assistido->get($field, $default) : $this->assistido;
	}
	
	public static function getAll($table="", $filter="TRUE"){
		$models = array();
		$ids = array();
	
		$sql = "SELECT id FROM assistencia WHERE $filter";
		Connection::query($sql);
	
		while ($row = Connection::next()) $ids[] = $row['id'];
		foreach ($ids as $id) $models[] = new self($id);
	
		return $models;
	}	

}
