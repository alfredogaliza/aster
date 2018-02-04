<?php
include_once "lib/Controller.php";
include_once "lib/Session.php";

class DefaultController extends Controller {
	
	public function __construct($action) {
		parent::__construct("default", $action );
		Session::start();
	}
	
	public function actionDefault() {
		if (Session::getUsuario('id')) {
			Controller::dispatch("home");
			return false;
		} else {			
			Controller::dispatch("login");
			return true;
		}
	}
}
