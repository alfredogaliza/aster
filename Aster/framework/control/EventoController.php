<?php


class EventoController extends Controller {
	
	
	public $id = NULL;	
	
	/**
	 * Construtor do controlador
	 * @param unknown $action Nome da ação a ser executada
	 */
	public function __construct($action){
		parent::__construct("evento", $action);
		Session::start();

		$this->id = Globals::get('id');
		$this->title = "";
		$this->msg = "";		
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
		$filters[] = ($acao_id = Globals::get('acao_id'))? "acao_id = '$acao_id'" : "TRUE";

		$inicio = Globals::getDate('data_inicio');
		$fim = Globals::getDate('data_fim');		
		$filters[] = $inicio? "data_inicio >= '$inicio'" : "TRUE";
		$filters[] = $fim? "data_fim <= '$fim'" : "TRUE";		
		
		switch ($status){
			case Evento::STATUS_ABERTO:
				$filters[] = "data_fim < NOW()";
				break;
			case Evento::STATUS_ANDAMENTO:
				$filters[] = "NOW() BETWEEN data_inicio AND data_fim";
				break;
			case Evento::STATUS_ENCERRADO:
				$filters[] = "data_fim > NOW()";
				break;
		}
		
		$filter = implode (" AND ", $filters);
		$offset = "OFFSET ".($page-1)*20;
		
		$this->eventos = Evento::getAll("", "$filter LIMIT 20 $offset");
		$this->setView('evento/table');
		return true;
	}
	
	
	
	/**
	 * Apresenta o modal com os dados do voluntário a ser editado/criado
	 * @return boolean
	 */
	public function actionModal(){
		$this->evento = new Evento($this->id);
		$this->tarefas = $this->evento->getTarefas();
		$this->assistencias = $this->evento->getAssistencias();
		$this->setView("evento/modal");
		return true;
	}
	
	/**
	 * Cadastra ou Altera os dados de um voluntário
	 * @return boolean
	 */
	public function actionGravar(){
	
		$nome = mb_strtoupper(Globals::post('nome'),'utf-8');	
		$this->evento = new Evento($this->id);
		$this->evento->setAttrs($_POST);
	
		$this->evento->set('nome', $nome);
		$this->evento->set('data_inicio', Globals::postDate('data_inicio'));
		$this->evento->set('data_fim', Globals::postDate('data_fim'));		
		
		if ($this->evento->update()){
			
			$assistencias_antigas = $this->evento->getAssistencias();
			$tarefas_antigas = $this->evento->getTarefas();
			
			$evento_id = $this->evento->get('id');
			$tarefas_novas = [];
			$assistencias_novas = [];
			
			foreach (Globals::post('assistencia_id', []) as $i => $assistencia_id){				
				$assistencia = new Assistencia($assistencia_id);
				$assistencia->set('evento_id', $evento_id);
				$assistencia->set('assistido_id', Globals::post('assistencia_assistido_id')[$i]);				
				$assistencia->set('descricao', Globals::post('assistencia_descricao')[$i]);
				$assistencia->set('concluida', Globals::post('assistencia_concluida')[$i]);				
				$assistencia->update();
				$assistencias_novas[] = $assistencia;
			}
			
			foreach (Globals::post('tarefa_id', []) as $i => $tarefa_id){
				$tarefa = new Tarefa($tarefa_id);
				$tarefa->set('evento_id', $evento_id);
				$tarefa->set('nome', mb_strtoupper(Globals::post('tarefa_nome')[$i],'utf-8'));
				$tarefa->set('descricao', Globals::post('tarefa_descricao')[$i]);
				$tarefa->set('data_fechamento', Globals::postDate('tarefa_data_fechamento')[$i]);
				$tarefa->set('data_agendada', Globals::postDate('tarefa_data_agendada')[$i]? Globals::postDate('tarefa_data_agendada')[$i] : NULL);
				$tarefa->set('max_atribuicoes', Globals::post('tarefa_max_atribuicoes')[$i]);
				$tarefa->update();
				$tarefas_novas[] = $tarefa;
			}
			
			foreach($assistencias_antigas as $antiga){
				$delete = true;
				foreach($assistencias_novas as $nova){
					if ($antiga->get('id') == $nova->get('id')){
						$delete = false;
						break;
					}						
				}
				if ($delete) $antiga->delete();
			}

			foreach($tarefas_antigas as $antiga){
				$delete = true;
				foreach($tarefas_novas as $nova){
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
		$evento = new Evento($this->id);
		$evento->delete();
		return false;
	}
	
}