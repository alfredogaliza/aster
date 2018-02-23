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
		
		$filter = "(NOT max_atribuicoes OR max_atribuicoes < atribuicoes OR NOT concluida)
					AND NOW() BETWEEN data_inicio AND data_fim ORDER BY data_inicio DESC $limit";
		
		$this->tarefas = Tarefa::getAll('',$filter);
		$this->setView('tarefa/ajax');
		return true;
	}	
	
	public function actionDefault(){		
		$this->setView("home/page");
		return true;
	}
	
}