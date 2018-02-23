<?php

class Model {
	
	private $attrs = array();
	protected $table = "";
	protected $id = 0;
	
	public function __construct($table, $id = NULL, $read = false){
		$this->table = $table;
		$this->id = $id? $id : NULL;
		
		if ($read) $this->read();
	}
	
	public function updateRelationships($nnTable, $myField, $hisField, $hisIds = []){
	
		$myId = $this->get('id');
		$sql = "DELETE FROM $nnTable WHERE $myField = '$myId'";
		Connection::query($sql);
	
		$values = [];
		foreach ($hisIds as $hisId) $values[] = "('$myId','$hisId')";
		$values = implode(", ", $values);
			
		$sql = "INSERT INTO $nnTable($myField, $hisField) VALUES $values";
		Connection::query($sql);
		
		return true;
	
	}
	
	public function getAttrs(){
		return $this->attrs;
	}

	public function serialize(){
		
		$serialized = "{$this->table} {";
		$attrs = array();
		
		foreach ($this->attrs as $key => $value) $attrs[] = "$key='$value'";
		
		$serialized .= implode(",", $attrs);
		$serialized .= "}";
		
		return $serialized;
	}

	public function create(){
		$values = array();
		foreach ($this->attrs as $value){			
			$values[] = is_null($value)?
				"NULL" :
				(($value == "NOW()")?
					$value :
					"'".addslashes(stripslashes($value))."'"
				);
		}
		$fields = implode(", ", array_keys($this->attrs));
		$values = implode(", ", $values);
		$sql = "INSERT INTO {$this->table}($fields) VALUES ($values)";
		Connection::query($sql);
		
		if (!$this->id) {
			$this->id = Connection::lastId();			
		}
		return $this->read();
	}
	
	public function replace(){
		$values = array();
		foreach ($this->attrs as $value){
			$values[] = is_null($value)?
			"NULL" :
			(($value == "NOW()")?
					$value :
					"'".addslashes(stripslashes($value))."'"
					);
		}
		$fields = implode(", ", array_keys($this->attrs));
		$values = implode(", ", $values);
		$sql = "REPLACE INTO {$this->table}($fields) VALUES ($values)";
		Connection::query($sql);
	
		if (!$this->id) {
			$this->id = Connection::lastId();
		}
		return $this->read();
	}
	
	public function read(){
		$id = $this->id? $this->id : $this->get('id');
		$sql = "SELECT * FROM {$this->table} WHERE id ='$id'";
		Connection::query($sql);
		$this->attrs = Connection::next();
		return ($this->attrs && true);
	}
	
	public function update(){		
		if ($id = $this->get('id')){
			$attrs = array();
			foreach ($this->attrs as $key => $value){
				$value = is_null($value)? "NULL" : "'".addslashes($value)."'";			
				$attrs[] = "$key = $value";
			}
			$attrs = implode(", ", $attrs);
			$sql = "UPDATE {$this->table} SET $attrs WHERE id='{$id}'";
		
			return Connection::query($sql) || false;
		} else {
			return $this->create();
		}
	}
	
	public function delete($confirm = true){
		if ($confirm){
			$sql = "DELETE FROM {$this->table} WHERE id ='{$this->id}'";
			$this->attrs = Connection::query($sql);
			return !$this->read();
		} 
		
		return false;
	}
	
	public function get($field, $default = null, $void = true){
		if (isset($this->attrs[$field])){
			if ($this->attrs[$field] || $void)
				return $this->attrs[$field];
		}
		return $default;	
	}
	
	public function getDate($field, $default = null){
		return preg_replace('#(\d+)-(\d+)-(\d+)#', "$3/$2/$1", $this->get($field, $default));
	}
	
	public function set($field, $value){
		if ($field == 'id') $this->id = $value;
		$this->attrs[$field] = $value;
		return $this;
	}
	
	public function setAttrs($attrs = []){
		
		$keys = [];
		Connection::query("DESCRIBE {$this->table}");
		while ($row = Connection::next(false)) $keys[] = $row[0];
		
		foreach ($attrs as $key => $value)
			if (in_array($key, $keys)) $this->set($key, $value);
	}
	
	
	public static function load($table, $data){		
		$keys = array();
		Connection::query("DESCRIBE $table");
		while ($row = Connection::next(false)) $keys[] = $row[0];
		
		$model = new self($table, null);
		foreach ($keys as $key) $model->set($key, isset($data[$key])? $data[$key] : NULL);
		return $model;
	}
	
	public static function getAll($table, $filter = "TRUE"){
		$ids = array();
		$models = array();
		
		$sql = "SELECT id FROM $table WHERE $filter";
		Connection::query($sql);
		
		while ($row = Connection::next()) $ids[] = $row['id'];
		foreach ($ids as $id) $models[] = new Model($table, $id, true);
		
		return $models;
	}
	
	public static function getAllRows($table, $filter = "TRUE"){
		$sql = "SELECT * FROM $table WHERE $filter";
		return self::getAllRowsSQL($sql);
	}

	public static function getAllRowsSQL($sql, $assoc = true){		
		Connection::query($sql);		
		for (
			$rows = array();
			$row = Connection::next($assoc);
			$rows[] = $row
		);		
		return $rows;
	}	
	
	public static function getOptions($table, $key, $value, $selected = NULL, $where = "TRUE", $order = "1"){
	
		$sql = "SELECT $key, $value FROM $table WHERE $where ORDER BY $order";
		
		return self::getOptionsSQL($sql, $selected);
	}
	
	public static function getOptionsSQL($sql, $selected = [], $void = ""){
		Connection::query($sql);
		
		$options = $void? "\t<option value=''>$void</option>\n" : "";		
		$selected = is_array($selected)? $selected : explode(',', $selected);
		
		while ($row = Connection::next(false)){
			$options .= "\t<option value='{$row[0]}' ".(in_array($row[0], $selected)? "selected" : "").">{$row[1]}</option>\n";
		}
		
		return $options;				
	}
	
	public static function makeOptions($models = array(), $selected_id = NULL, $key = 'id', $value = 'descricao'){
		$options = "";
		
		foreach ($models as $model){
			$options .= "<option value='".$model->get($key)."' ".(($selected_id == $model->get($key))? "selected" : "").">"
							.$model->get($value).
						"</option>\n";
		}
		
		return $options;
	}
	
}