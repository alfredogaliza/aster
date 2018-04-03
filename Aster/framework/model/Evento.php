<?php

class Evento extends Model {
	
	const STATUS_ABERTO = 1;
	const STATUS_ANDAMENTO = 2;
	const STATUS_ENCERRADO = 3;
	
	protected $acao = NULL;
	protected $tarefas = NULL;
	protected $assistencias = NULL;
	
	public function __construct($id = null, $read = true){
		parent::__construct("evento", $id, $read);
	}	
	
	public function getStatus(){
		$today = new DateTime();
		if ($today < date_create_from_format('Y-m-d H:i:s', $this->get('data_inicio')))
			return self::STATUS_ABERTO;
		else if ($today < date_create_from_format('Y-m-d H:i:s', $this->get('data_fim')))
			return self::STATUS_ANDAMENTO;
		else
			return self::STATUS_ENCERRADO; 
	}
	
	public function getStatusClass(){
		$classes = [
			self::STATUS_ABERTO => "bg-warning",
			self::STATUS_ANDAMENTO => "bg-info",
			self::STATUS_ENCERRADO => "bg-success"
		];
		
		return $classes[$this->getStatus()];
	}
	
	public function getAcao($field = NULL, $default = NULL){
		if (is_null($this->acao)){
			$this->acao = new Acao($this->get('acao_id'));
		}
		return $field? $this->acao->get($field, $default) : $this->acao;
	}	
	
	public function getTarefas(){
		if (is_null($this->tarefas)){
			$id = $this->get('id');
			$this->tarefas = Tarefa::getAll('', "evento_id='$id'");
		}
		return $this->tarefas;
	}
	public function getAssistencias(){
		if (is_null($this->assistencias)){
			$id = $this->get('id');
			$this->assistencias = Assistencia::getAll('', "evento_id='$id'");
		}
		return $this->assistencias;
	}
	public function delete($confirm = true){
		
		if ($confirm){
			$id = $this->get('id');
			$sql = "UPDATE voluntario SET evento_id = NULL WHERE evento_id = '$id'";
			Connection::query($sql);
			return parent::delete();
		}
		
		return false;
	}
	
	public static function getAll($table="", $filter="TRUE"){
		$models = array();
		$ids = array();
	
		$sql = "SELECT id FROM evento WHERE $filter";
		Connection::query($sql);
	
		while ($row = Connection::next()) $ids[] = $row['id'];
		foreach ($ids as $id) $models[] = new self($id);
	
		return $models;
	}	

}
