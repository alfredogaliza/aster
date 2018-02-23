<?php

class Config{
	
	const USE_RECAPTCHA = false;
	const SYS_SIGLA  = "ASTER";
	const SYS_TITULO = "Instituto Áster de Combate ao Câncer";
	
	const COOKIE_FILE = ".cookie";
	const UPLOAD_DIR_ANEXO = "/var/www/aster/files/anexo/";
	const MAX_UPLOAD_SIZE = 10485760; // 10 MB
	
	const REWRITE = 1;
	const PROTOCOL = "http://";
	const BASE_URL = "/";		

	
	private static $configs = [];
	
	public static function get($key){
		return self::$configs[$key];
	}
	
	public static function set($key, $value){
		self::$configs[$key] = $value;
	}
		
	public static function makeOptions($array, $selected = NULL){
		$options = [];
		foreach ($array as $item)
			$options[] = "<option value='$item' ".(($selected == $item)? 'selected' : '').">$item</option>";
		return implode("\n", $options);
	}
	
	public static function baseURL(){
		return self::PROTOCOL . $_SERVER['SERVER_NAME'] . self::BASE_URL; 
	}
	

	public static function toDateDMY($ymd){
		return preg_replace("#(\d+)-(\d+)-(\d+)#", "$3/$2/$1", $ymd);
	}
	
	public static function toDateYMD($dmy){
		return preg_replace("#(\d+)/(\d+)/(\d+)#", "$3-$2-$1", $dmy);
	}
		
}
