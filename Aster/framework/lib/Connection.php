<?php

class Connection {
		
	private static $host = "aster.mysql.uhserver.com";
	private static $user = "bdaster";
	private static $pass = "1careca@";
	private static $base = "aster";
	private static $cset = "utf8";
	private static $port = 3306;
	
	/**
	 * @var mysqli
	 */
	private static $mysqli = null;
	
	/**
	 * 
	 * @var mysqli_result
	 */
	private static $result = null;
	
	private function __construct(){}
	
	public static function query($sql, $die = true, $error = true){				
		self::connect();
		if (self::$result){
			self::$result = null;
		}
		self::$result = self::$mysqli->query($sql, MYSQLI_STORE_RESULT)
			or print(self::$mysqli->error.":<br><strong>$sql</strong>") and $die and die;;	
		return (self::$result || false);
	}
	
	public static function affectedRows(){
		if (self::isConnected()){
			return self::$mysqli->affected_rows;
		} else {
			return false;
		}
	}
	
	public static function next($assoc = true){
		if (self::isConnected() && self::$result){			
			return $assoc? self::$result->fetch_assoc() : self::$result->fetch_row();
		} else {
			return null;
		}
	}
	
	public static function count(){
		if (self::isConnected() && self::$result && self::$mysqli){
			self::$mysqli->store_result();			
			return self::$result->num_rows;
		} else {
			return null;
		}
	}
	
	public static function lastId(){
		if (self::isConnected()){
			return self::$mysqli->insert_id;
		} else {
			return false;
		}
	}

	public static function error(){
		echo self::$mysqli->error;
	}
	
	public static function charset($cset = false){
		if ($cset && self::isConnected()){
			self::$cset = $cset;
			return self::$mysqli->set_charset(self::$cset);
			
		} else {
			return self::$cset;
		}
	}
	
	public static function connect(){
		if ( !self::isConnected() ){
			try {
				self::$mysqli = new mysqli(
						self::$host,
						self::$user,
						self::$pass,
						self::$base,
						self::$port);
				self::$mysqli->options(MYSQLI_INIT_COMMAND, "SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
				self::charset(self::$cset);
				self::query("SET SQL_MODE=''");
				
			} catch (Exception $e){
				echo $e->getMessage();
				self::$mysqli = null;
				return false;
			}
		}
		
		return true;
	}
	
	public static function isConnected(){
		return (self::$mysqli || false);
	}
	
	public static function disconnect(){
		self::$mysqli = null;
		self::$result = null;
	}
	
}