<?php


class Session {
	
	
	
	private function __construct(){}
	
	public static function start(){
		if (!self::isStarted()){
			session_start();
			session_id();
		}
	}
	
	public static function set($key, $value){
		$_SESSION[$key] = $value;
		return true;
	}
	
	public static function get($key){
		if (self::isStarted() && isset($_SESSION[$key])){
			return $_SESSION[$key];
		} else {
			return null;
		}
	}
	
	public static function getUsuario($field = false){
		if ($usuario = self::get('usuario'))
			return $field? $usuario->get($field) : $usuario;
		else
			return $field? NULL : new Usuario;
	}
	
	public static function setUsuario($usuario){
		self::set('usuario', $usuario);
	}
	
	public static function isStarted(){
		return session_id() || false;
	}
	
	public static function destroy(){
		if (self::isStarted()){
			$_SESSION = array();
			if (isset($_COOKIE[session_name()])) {
			    setcookie(session_name(), '', time()-42000, '/');
			}
			return session_destroy();
		} else {
			return true;
		}
	}
}
