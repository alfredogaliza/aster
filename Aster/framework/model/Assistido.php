<?php

class Assistido extends Model {
	
	const STATUS_INICIO = 1;
	const STATUS_TRATAMENTO = 2;
	const STATUS_MANUTENCAO = 3;
	const STATUS_RECAIDA = 4;
	const STATUS_CURA = 5;
	CONST STATUS_INATIVO = 6; 
	
	protected $responsaveis = NULL;
	protected $cidade = NULL;
	
	public function __construct($id = null, $read = true){
		parent::__construct("assistido", $id, $read);
	}
	
	public function delete($confirm = true){
		$this->set('excluido', 1);
		return $this->update();
	}
	
	public function getStatus(){
		return $this->get('fase_tratamento');
	}
	
	public function getStatusClass(){
		$classes = [
			self::STATUS_INICIO => 'bg-primary',
			self::STATUS_TRATAMENTO => 'bg-warning',
			self::STATUS_MANUTENCAO => 'bg-info',
			self::STATUS_RECAIDA => 'bg-danger',
			self::STATUS_CURA => 'bg-success',
			self::STATUS_INATIVO => 'bg-default'
		];
		
		return $classes[$this->getStatus()];
	}
	
	public function getResponsaveis(){
		if (is_null($this->responsaveis)){
			$id = $this->get('id');
			$this->responsaveis = Responsavel::getAll('', "assistido_id='$id'");
		}
		return $this->responsaveis;
	}
	
	public function getCidade($field = NULL, $default = NULL){
		if (is_null($this->cidade)){
			$this->cidade = new Model('cidade', $this->get('cidade_id'), true);
		}
		return $field? $this->cidade->get($field, $default) : $this->cidade;
	}

	
	public static function getAll($table="", $filter="TRUE"){
		$models = array();
		$ids = array();
	
		$sql = "SELECT a.id FROM assistido a LEFT JOIN cidade c ON c.id = a.cidade_id WHERE $filter";
		Connection::query($sql);
	
		while ($row = Connection::next()) $ids[] = $row['id'];
		foreach ($ids as $id) $models[] = new self($id);
	
		return $models;
	}	

}
