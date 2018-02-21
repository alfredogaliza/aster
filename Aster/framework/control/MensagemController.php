<?php

class MensagemController extends Controller {

	public function __construct($action){
		parent::__construct("mensagem", $action);
		Session::start();
	}
	
	public function actionDefault(){
		return false;
	}
	
	public function actionAjax(){
		$page = Globals::post('page', Globals::get('page', 1));
		
		$id = Session::getVoluntario('id');
		$filter = "remetente_id = '$id' OR destinatario_id = '$id' OR TRUE ORDER BY datahora DESC LIMIT 5 OFFSET ".(($page-1)*5);
		$this->mensagens = Mensagem::getAll("", $filter);
		
		$this->setView('mensagem/ajax');
		return ($this->mensagens || false);
	}
	
}
