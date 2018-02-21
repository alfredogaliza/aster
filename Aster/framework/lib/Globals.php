<?php

class Globals{
	
	public static function get($key, $default = NULL){
		return (isset($_GET[$key]) && $_GET[$key])? $_GET[$key] : $default;
	}
	
	public static function getDate($key, $default = NULL){
		return self::get($key)? preg_replace("#(\d+)/(\d+)/(\d+)#", "$3-$2-$1", self::get($key)) : $default;
	}
	
	public static function post($key, $default = NULL){
		return (isset($_POST[$key]) && $_POST[$key])? $_POST[$key] : $default;
	}
	
	public static function postDate($key, $default = NULL){
		return self::post($key)? preg_replace("#(\d+)/(\d+)/(\d+)#", "$3-$2-$1", self::post($key)) : $default;
	}	
	
}
