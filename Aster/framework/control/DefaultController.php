<?php
class DefaultController extends Controller {
	
	public function __construct($action) {
		parent::__construct("default", $action );
		Session::start();
	}
	
	public function actionDefault() {
		if (Session::getVoluntario('id')) {
			Controller::dispatch("home");
			return false;
		} else {			
			Controller::dispatch("login");
			return true;
		}
	}
}
