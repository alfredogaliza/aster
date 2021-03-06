

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
		$efetivo = Session::getVoluntario()->isEfetivo()? "TRUE" : "FALSE";
		$aberta = Tarefa::STATUS_ABERTA;
		
		/**
		 * Seleciona as tarefas que estejam abertas e naquelas que o
		 * voluntário tenha se inscrito e ainda não tenha se atribuído.
		 * Se ainda não for efetivado, mostrar somente as tarefas de efetivação.
		 */		
		$filter = "($efetivo XOR efetivacao) AND status = '$aberta' AND id NOT IN (
						SELECT tarefa_id FROM atribuicao WHERE voluntario_id = '$voluntario_id'
					) AND acao_id IN (
						SELECT acao_id FROM voluntario_acao
						LEFT JOIN acao on acao.id = acao_id
						WHERE voluntario_id = '$voluntario_id'
							OR acao.obrigatorio 
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
		foreach ($agenda as &$dia){
			$dia['classname'] = $dia['eventos']? 'bg-info' : '';
			$dia['badge'] = ($dia['tarefas'] || false);
			$dia['popover'] = false;
			$dia['modal'] = false;
		}
		echo json_encode($agenda);

		return false;
	}	
	
	public function actionDefault(){		
		$this->setView("home/page");
		return true;
	}
	
}