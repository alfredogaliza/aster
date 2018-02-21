<?php

class NoticiaController extends Controller {

	public function __construct($action){
		parent::__construct("noticia", $action);
		Session::start();
	}
	
	public function actionDefault(){
		return false;
	}
	
	public function actionAjax(){
		$page = Globals::post('page', Globals::get('page', 1));
		$filter = "TRUE ORDER BY datahora DESC LIMIT 5 OFFSET ".(($page-1)*5);
		$this->noticias = Noticia::getAll("", $filter);
		
		$this->setView('noticia/ajax');
		return true;
	}
	
}
