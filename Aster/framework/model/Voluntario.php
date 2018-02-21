<?php

class Voluntario extends Model {
	
	const STATUS_OK = 1;
	const STATUS_BLOCK = 2;
	const STATUS_CONFIRM = 3;
	const STATUS_NOTEFFECTIVE = 4;
	
	public function __construct($id = null, $read = true){
		parent::__construct("voluntario", $id, $read);
	}	
	
	public function getStatus(){
		if ($this->get('ativo') && $this->get('confirmado') && $this->get('evento_id'))
			return self::STATUS_OK;
		else if ($this->get('ativo') && $this->get('confirmado') && !$this->get('evento_id'))
			return self::STATUS_NOTEFFECTIVE;
		else if (!$this->get('ativo'))
			return self::STATUS_BLOCK;
		else
			return self::STATUS_CONFIRM;
	}
	
	public function getStatusClass(){
		$classes = [
				self::STATUS_OK => "bg-success",
				self::STATUS_BLOCK => "bg-danger",
				self::STATUS_CONFIRM => "bg-warning",
				self::STATUS_NOTEFFECTIVE => "bg-info"
		];
		
		return $classes[$this->getStatus()];
	}

	public function getPerfil($field = false){
		$perfil = new Perfil($this->get('perfil_id'));
		return $field? $perfil->get($field) : $perfil;
	}
	
	public function hasAcao($id, $default = false){
		$voluntario_id = $this->get('id');
		return 
			Model::getAllRowsSQL("SELECT 1 FROM voluntario_acao WHERE voluntario_id = '$voluntario_id' AND acao_id = '$id'")
			|| $default;
	}
	
	public function getMenus(){
		$perfil_id = $this->get('perfil_id');
		
		$ids = array();
		$menus = array();
		
		$sql = "SELECT m.id as id FROM menu m
				LEFT JOIN recurso r ON m.id = r.menu_id
				LEFT JOIN perfil_recurso pr ON pr.recurso_id = r.id
				WHERE pr.perfil_id = '$perfil_id'
				GROUP BY m.id
				ORDER BY m.ordem";
		
		Connection::query($sql);
		
		while ($resultado = Connection::next()) $ids[] = $resultado['id'];		
		foreach ($ids as $id) $menus[] = new Model("menu", $id, true);

		return $menus;
	}	
	
	public function getRecursos($menu = NULL){
		if ($menu instanceof Model) {
			$menu_id = $menu->get('id');
			$filtro = "r.menu_id = '$menu_id'";
		} else {
			$filtro = "TRUE";
		}
		
		$perfil_id = $this->get('perfil_id');
		
		$ids = array();
		$recursos = array();
		
		$sql = "SELECT r.id as id FROM recurso r
				LEFT JOIN perfil_recurso pr ON pr.recurso_id = r.id
				WHERE pr.perfil_id = '$perfil_id' AND $filtro
				GROUP BY r.id
				ORDER BY r.ordem";
		
		Connection::query($sql);
		
		while ($resultado = Connection::next()) $ids[] = $resultado['id'];		
		foreach ($ids as $id) $recursos[] = new Model("recurso", $id, true);

		return $recursos;		
	}
	
	public function hasPermission($controller, $action){
		foreach ($this->getRecursos() as $recurso){
			if ($recurso->get('controle') == $controller && $recurso->get('acao') == $action)
				return true;
		}
		return false;
	}
	
	public function updateAcoes($ids = []){
		return $this->updateRelationships('voluntario_acao', 'voluntario_id', 'acao_id', $ids);	
	}
	
	public function checkPermission($controller, $action){
		$this->hasPermission($controller, $action)
			or die("Acesso Negado! Fa&ccedil;a um novo login aqui: <a href='".Controller::route('login', 'logoff')."'>Login</a>");
	}
	
	public static function getAll($table="", $filter="TRUE"){
		$usuarios = array();
		$ids = array();
	
		$sql = "SELECT id FROM voluntario WHERE $filter";
		Connection::query($sql);
	
		while ($row = Connection::next()) $ids[] = $row['id'];
		foreach ($ids as $id) $usuarios[] = new self($id);
	
		return $usuarios;
	}	
	
	public static function logon($email, $senha){

		$sql = "
		SELECT id
		FROM voluntario 
		WHERE email='$email' AND senha=UPPER('$senha')";
			
		Connection::query($sql);
		
		if ($resultado = Connection::next()){		
			return new self($resultado['id']);
		} else {
			return null;
			
		}
		
	}

}
