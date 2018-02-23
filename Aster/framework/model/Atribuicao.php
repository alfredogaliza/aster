<?php

class Atribuicao extends Model {
	
	const STATUS_ANDAMENTO = 1;
	const STATUS_CONCLUIDA = 2;	
	
	protected $voluntario = NULL;
	protected $tarefa = NULL;
	
	public function __construct($id = null, $read = true){
		parent::__construct("atribuicao", $id, $read);
	}
	
	public function getStatus(){
		if ($this->get('concluida')) return self::STATUS_CONCLUIDA;
		else return self::STATUS_ANDAMENTO;
	}
	
	public function getStatusPanelClass(){
		$classes = [
				self::STATUS_ANDAMENTO => "panel-warning",
				self::STATUS_CONCLUIDA => "panel-success"
		];
	
		return $classes[$this->getStatus()];
	}
	
	public function getStatusClass(){
		$classes = [
				self::STATUS_ANDAMENTO => "bg-warning",
				self::STATUS_CONCLUIDA => "bg-success"
		];
	
		return $classes[$this->getStatus()];
	}	
	
	public function getVoluntario($field = NULL, $default = NULL){
		if (is_null($this->voluntario)){
			$this->voluntario = new Voluntario($this->get('voluntario_id'));
		}
		return $field? $this->voluntario->get($field, $default) : $this->voluntario;
	}
	
	public function getTarefa($field = NULL, $default = NULL, $date = false){
		if (is_null($this->tarefa)){
			$this->tarefa = new Tarefa($this->get('tarefa_id'));
		}
		if ($date){
			return $this->tarefa->getDate($field, $default);
		}
		return $field? $this->tarefa->get($field, $default) : $this->tarefa;
	}	
	
	public static function getAll($table="", $filter="TRUE"){
		$models = array();
		$ids = array();
	
		$sql = "SELECT id FROM atribuicao WHERE $filter";
		Connection::query($sql);
	
		while ($row = Connection::next()) $ids[] = $row['id'];
		foreach ($ids as $id) $models[] = new self($id);
	
		return $models;
	}	

}
