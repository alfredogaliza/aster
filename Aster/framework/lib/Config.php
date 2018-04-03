<?php

/**
 * Classe de gerenciamento do sistema
 * @author alfredo
 *
 */
class Config{
	
	/**
	 * Usa ou não o recaptcha
	 * @var string
	 */
	const USE_RECAPTCHA = false;
	/**
	 * A sigla do sistema
	 * @var string
	 */
	const SYS_SIGLA  = "ASTER";
	
	/**
	 * O título do Sistema
	 * @var string
	 */
	const SYS_TITULO = "Instituto Áster de Combate ao Câncer";
	
	/**
	 * Arquivo de gravação de cookies pelo CURL
	 * @var string
	 */
	const COOKIE_FILE = ".cookie";
	
	/**
	 * Diretório de upload de arquivos
	 * @var string
	 */
	const UPLOAD_DIR_ANEXO = "/var/www/aster/Aster/files/anexo/";
	
	/**
	 * Diretório de upload de fotos de assistidos
	 * @var string
	 */
	const UPLOAD_DIR_FOTO_ASSISTIDO = "/var/www/aster/Aster/files/foto/assistido/";
	
	/**
	 * Diretório de upload de fotos de voluntários
	 * @var string
	 */
	const UPLOAD_DIR_FOTO_VOLUNTARIO = "/var/www/aster/Aster/files/foto/voluntario/";
	
	/**
	 * Tamanho máximo de upload, em Bytes
	 * @var integer
	 */
	const MAX_UPLOAD_SIZE = 10485760; // 10 MB
	
	/**
	 * Utiliza ou não o módulo apache rewrite
	 * @var integer
	 */
	const REWRITE = 1;
	
	/**
	 * Porotocolo do servidor
	 * @var string
	 */
	const PROTOCOL = "http://";
	
	/**
	 * Caminho raiz do sistema
	 * @var string
	 */
	const BASE_URL = "/";		

	
	private static $configs = [];
	

	/**
	 * 
	 * @param string $key
	 * @return mixed
	 */
	public static function get(string $key){
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
