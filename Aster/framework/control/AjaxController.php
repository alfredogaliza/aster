<?php
include_once "lib/Controller.php";
include_once "lib/Globals.php";
include_once "lib/Session.php";
include_once "lib/Model.php";

class AjaxController extends Controller {

	public function __construct($action){
		parent::__construct("ajax", $action);
		Session::start();
	}
	
	public function actionDefault(){
		return false;
	}
	
	public function actionBairro(){
		
		$cidade_id = Globals::get('id');
		$filter = "cidade_id ='$cidade_id'";
		
		echo "<option value=''>Selecione um bairro</option>";
		echo Model::getOptions('bairro', 'id', 'nome', NULL, $filter, 'nome');
		
		return false;
	}
	
}
