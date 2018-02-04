<?php

class View {
	private function __construct(){}
	
	public static function includeBlock($block){
		include "view/blocks/$block.php";		
	}
}
