<?php


class TarefaController extends Controller {
	
	
	public $id = NULL;	
	
	/**
	 * Construtor do controlador
	 * @param unknown $action Nome da ação a ser executada
	 */
	public function __construct($action){
		parent::__construct("tarefa", $action);
		Session::start();

		$this->id = Globals::get('id');
		$this->title = "";
		$this->msg = "";		
	}
	
	public function actionAjaxAberta(){
		return false;
	}
	
	/**
	 * Apresenta a tabela de usuários filtrada e paginada pelos parâmetros repassados
	 * @return boolean
	 */
	public function actionTable(){
		$filters = [];
		$page = Globals::post('page', Globals::get('page', 1));
		$status = Globals::get('status');
		
		$filters[] = ($nome = Globals::get('nome'))? "nome LIKE'%$nome%'" : "TRUE";
		$filters[] = ($evento_id = Globals::get('evento_id'))? "evento_id = '$evento_id'" : "TRUE";

		$inicio = Globals::getDate('data_inicio');
		$fim = Globals::getDate('data_fim');		
		$filters[] = $inicio? "data_inicio >= '$inicio'" : "TRUE";
		$filters[] = $fim? "data_fim <= '$fim'" : "TRUE";		
		
		switch ($status){
			case Tarefa::STATUS_ABERTA:
				$filters[] = "NOT atribuicoes";
				break;
			case Tarefa::STATUS_ANDAMENTO:
				$filters[] = "atribuicoes AND NOT concluida";
				break;
			case Tarefa::STATUS_CONCLUIDA:
				$filters[] = "atribuicoes AND concluida";
				break;
		}
		
		$filter = implode (" AND ", $filters);
		$offset = "OFFSET ".($page-1)*20;
		
		$this->tarefas = Tarefa::getAll("", "$filter LIMIT 20 $offset");
		$this->setView('tarefa/table');
		return true;
	}
	
	
	
	/**
	 * Apresenta o modal com os dados do voluntário a ser editado/criado
	 * @return boolean
	 */
	public function actionModal(){
		$this->tarefa = new Tarefa($this->id);
		$this->atribuicoes = $this->tarefa->getAtribuicoes();
		$this->setView("tarefa/modal");
		return true;
	}
	
	/**
	 * Cadastra ou Altera os dados de um voluntário
	 * @return boolean
	 */
	public function actionGravar(){
	
		$nome = mb_strtoupper(Globals::post('nome'),'utf-8');	
		$this->tarefa = new Tarefa($this->id);
		$this->tarefa->setAttrs($_POST);
	
		$this->tarefa->set('nome', $nome);
		$this->tarefa->set('data_inicio', Globals::postDate('data_inicio'));
		$this->tarefa->set('data_fim', Globals::postDate('data_fim'));		
		
		if ($this->tarefa->update()){
			
			$atribuicoes_antigas = $this->tarefa->getAtribuicoes();			
			$tarefa_id = $this->tarefa->get('id');
			$atribuicoes_novas = [];
			foreach (Globals::post('atribuicao_id', []) as $i => $atribuicao_id){				
				$atribuicao = new Atribuicao($atribuicao_id);
				$atribuicao->set('tarefa_id', $tarefa_id);
				$atribuicao->set('voluntario_id', Globals::post('atribuicao_voluntario_id')[$i]);				
				$atribuicao->set('concluida', Globals::post('atribuicao_concluida')[$i]);				
				$atribuicao->update();
				$atribuicoes_novas[] = $atribuicao;
			}			
			
			foreach($atribuicoes_antigas as $antiga){
				$delete = true;
				foreach($atribuicoes_novas as $nova){
					if ($antiga->get('id') == $nova->get('id')){
						$delete = false;
						break;
					}						
				}
				if ($delete) $antiga->delete();
			}
					
		}
	
		return false;
	
	}
	
	public function actionDelete(){
		$tarefa = new Tarefa($this->id);
		$tarefa->delete();
		return false;
	}
	
}