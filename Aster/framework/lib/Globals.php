<?php

class Globals{
	
	public static function get($key, $default = NULL){
		if (isset($_GET[$key]) && $_GET[$key]){
			return is_array($_GET[$key])?
			$_GET[$key] : addslashes($_GET[$key]);
		} else {
			return $default;
		}
	}
	
	public static function getDate($key, $default = NULL){
		return self::get($key, $default)?
			preg_replace("#(\d+)/(\d+)/(\d+)#", "$3-$2-$1", self::get($key, $default)) : $default;
	}
	
	public static function post($key, $default = NULL){
		if (isset($_POST[$key]) && $_POST[$key]){
			return is_array($_POST[$key])?
			$_POST[$key] : addslashes($_POST[$key]);
		} else {
			return $default;
		}
	}
	
	public static function postDate($key, $default = NULL){
		return self::post($key, $default)?
			preg_replace("#(\d+)/(\d+)/(\d+)#", "$3-$2-$1", self::post($key, $default)) : $default;
	}	
	
}
