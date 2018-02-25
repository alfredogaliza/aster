<?php

class Tarefa extends Model {
	
	const STATUS_ABERTA = 1;
	const STATUS_ANDAMENTO = 2;
	const STATUS_CONCLUIDA = 3;
	
	protected $atribuicoes = NULL;
	protected $evento = NULL;
	
	public function __construct($id = null, $read = true){
		parent::__construct("tarefa", $id, $read);
	}	
	
	public function getStatus(){
		$id = $this->get('id');
		$sql = "SELECT status FROM lista_tarefa WHERE id = '$id'";
		Connection::query($sql);
		if ($row = Connection::next())
			return $row['status'];
		else return self::STATUS_ABERTA;
	}
	
	public function getStatusPanelClass(){
		$classes = [
				self::STATUS_ABERTA => "panel-warning",
				self::STATUS_ANDAMENTO => "panel-info",
				self::STATUS_CONCLUIDA => "panel-success"
		];
	
		return $classes[$this->getStatus()];
	}	
	
	public function getStatusClass(){
		$classes = [
			self::STATUS_ABERTA => "bg-warning",
			self::STATUS_ANDAMENTO => "bg-info",
			self::STATUS_CONCLUIDA => "bg-success"
		];
		
		return $classes[$this->getStatus()];
	}
	
	public function getEvento($field = NULL, $default = NULL){
		if (is_null($this->evento)){
			$this->evento = new Evento($this->get('evento_id'));
		}
		return $field? $this->evento->get($field, $default) : $this->evento;
	}
	
	public function getAtribuicoes(){
		if (is_null($this->atribuicoes)){
			$id = $this->get('id');
			$this->atribuicoes = Atribuicao::getAll('atribuicao', "tarefa_id='$id'");
		}
		return $this->atribuicoes;
	}
	
	public function getConcluidas(){
		$concluidas = 0;
		foreach ($this->getAtribuicoes() as $atribuicao){
			$concluidas += $atribuicao->get('concluida');
		}
		return $concluidas;
	}
	
	public static function getAll($table="", $filter="TRUE"){
		$models = array();
		$ids = array();
	
		$sql = "SELECT id FROM lista_tarefa WHERE $filter";
		Connection::query($sql);
	
		while ($row = Connection::next()) $ids[] = $row['id'];
		foreach ($ids as $id) $models[] = new self($id);
	
		return $models;
	}	

}
