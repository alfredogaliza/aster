<?php
class HomeController extends Controller {
	public $msg   = "";
	
	public function __construct($action){
		parent::__construct("home", $action);
		Session::start();
	}
	
	public function actionAtribuicoes(){
		$page = Globals::post('page', Globals::get('page', 1));
		$this->atribuicoes = Session::getVoluntario()->getAtribuicoes("NOT concluida", 10, $page);
		$this->setView('atribuicao/ajax');
		return true;
	}
	
	public function actionTarefas(){
		
		$page = Globals::post('page', Globals::get('page', 1));
		
		$limit = "LIMIT 10 OFFSET ".(10*($page-1));
		$voluntario_id = Session::getVoluntario('id');
		$aberta = Tarefa::STATUS_ABERTA;
		
		/**
		 * Seleciona as tarefas que estejam abertas e naquelas que o
		 * voluntário tenha se inscrito e ainda não tenha se atribuído.
		 */		
		$filter = "status = '$aberta' AND id NOT IN (
						SELECT tarefa_id FROM atribuicao WHERE voluntario_id = '$voluntario_id'
					) AND acao_id IN (
						SELECT acao_id FROM voluntario_acao WHERE voluntario_id = '$voluntario_id' 
					) ORDER BY data_fechamento ASC $limit";
		
		$this->tarefas = Tarefa::getAll('',$filter);
		$this->setView('tarefa/ajax');
		return true;
	}
	
	public function actionAgenda(){
		header("Content-type: text/json");
		
		$mes = str_pad(Globals::get('month', date('m')), 2, '0', STR_PAD_LEFT);
		$ano = str_pad(Globals::get('year', date('Y')), 4, '0', STR_PAD_LEFT);
		
		$agenda = Session::getVoluntario()->getAgenda($mes, $ano);
		
		echo json_encode($agenda);

		return false;
	}	
	
	public function actionDefault(){		
		$this->setView("home/page");
		return true;
	}
	
}