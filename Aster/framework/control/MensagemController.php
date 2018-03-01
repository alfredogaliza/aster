<?php

class MensagemController extends Controller {

	protected $id = NULL;
	
	public function __construct($action){
		parent::__construct("mensagem", $action);
		Session::start();
		
		$this->id = Globals::get('id');
	}
	
	public function actionDefault(){
		return false;
	}
	
	public function actionAjax(){
		$page = Globals::post('page', Globals::get('page', 1));
		
		$id = Session::getVoluntario('id');
		$filter = "destinatario_id = '$id' ORDER BY datahora DESC LIMIT 5 OFFSET ".(($page-1)*5);
		$this->mensagens = Mensagem::getAll("", $filter);
		
		$this->setView('mensagem/ajax');
		return ($this->mensagens || false);
	}
	
	public function actionDelete(){
		$mensagem = new Mensagem($this->id);
		$mensagem->delete();
		return false;
	}
	
	public function actionModal(){		
		$this->mensagem = new Mensagem($this->id);			
		$this->setView('mensagem/modal');
		return true;
	}
	
	public function actionModalReply(){
	
		$this->mensagem = new Mensagem($this->id);
	
		$this->mensagens = $this->mensagem->getConversa();
	
		if (!$this->mensagem->get('data_leitura')){
			$this->mensagem->set('data_leitura', date('Y-m-d H:i:s'));
			$this->mensagem->update();
		}
	
		$this->setView('mensagem/modalReply');
		return true;
	}	
	
	public function actionGravar(){
		
		foreach (Globals::post('destinatario_ids', []) as $destinatario_id){
			$mensagem = new Mensagem();
			$mensagem->setAttrs($_POST);
			$mensagem->set('destinatario_id', $destinatario_id);
			$mensagem->update();
		}
		
		return false;
	}
	
	public function actionResponder(){
		$mensagem = new Mensagem();
		$mensagem->setAttrs($_POST);
		$mensagem->set('datahora', date("Y-m-d H:i:s"));
		$mensagem->update();
		return false;
	}
	
}
