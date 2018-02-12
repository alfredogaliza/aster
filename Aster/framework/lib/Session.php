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
	
	public static function get($key, $default = NULL){
		if (self::isStarted()){
			if (isset($_SESSION[$key]))
				return $_SESSION[$key];
			else {
				self::set($key, $default);				
			}
		}
		return $default;
	}
	
	public static function getVoluntario($field = false){
		if ($usuario = self::get('voluntario'))
			return $field? $usuario->get($field) : $usuario;
		else
			return $field? NULL : new Voluntario;
	}
	
	public static function setVoluntario($voluntario){
		self::set('voluntario', $voluntario);
	}
	
	public static function isStarted(){
		return session_id() || false;
	}
	
	public static function restart(){
		self::destroy();
		session_start();
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
