<?php

class Usuario extends Model {

	public function __construct($id = null, $read = true){
		parent::__construct("voluntario", $id, $read);
	}	
	
	public function reset(){
		$this->set("senha", strtoupper(md5("12345")));
		$this->update();		
	}

	public function getPerfil($field = false){
		$perfil = new Perfil($this->get('perfil_id'));
		return $field? $perfil->get($field) : $perfil;
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
