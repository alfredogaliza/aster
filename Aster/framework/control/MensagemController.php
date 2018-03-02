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
		$text = str_replace(" ", " ", Globals::get('msg-filter', ''));
		
		$filter = "remetente_nome LIKE '%$text%' OR destinatario_nome LIKE '%$text%' OR assunto LIKE '%$text%'";
		
		$id = Session::getVoluntario('id');
		$filter = "(destinatario_id = '$id' OR remetente_id = '$id') AND ($filter) ORDER BY datahora DESC LIMIT 5 OFFSET ".(($page-1)*5);
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
			$mensagem->set('remetente_id', Globals::post('remetente_id', Session::getVoluntario('id')));
			$mensagem->set('datahora', date("Y-m-d H:i:s"));
			$mensagem->update();
		}
		
		return false;
	}
	
	public function actionDestinatarios(){
		
		$voluntario_id = Session::getVoluntario('id');
		
		$acao_ids = implode("','", Globals::post('acao_ids', []));
		$perfil_ids = implode("','",Globals::post('perfil_ids', []));
		$destinatario_ids = Globals::post('destinatario_ids', []);		
		
		$filter = ["v.id <> '$voluntario_id'", "NOT v.excluido"];
		$filter[] = $acao_ids? "va.acao_id IN ('$acao_ids')" : TRUE;
		$filter[] = $perfil_ids? "v.perfil_id IN ('$perfil_ids')" : TRUE;
		
		$filter = implode (" AND ", $filter);
		
		$sql = "SELECT v.id, v.nome FROM voluntario v
				LEFT JOIN voluntario_acao va ON va.voluntario_id = v.id
				WHERE $filter 
				GROUP BY 1, 2
				ORDER BY 2";
		
		echo Model::getOptionsSQL($sql, $destinatario_ids);
		
	}	
	
}
