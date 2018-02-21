<?php
class HomeController extends Controller {
	public $msg   = "";
	
	public function __construct($action){
		parent::__construct("home", $action);
		Session::start();
	}
	
	public function actionDefault(){		
		$this->setView("home/page");
		return true;
	}
	
}