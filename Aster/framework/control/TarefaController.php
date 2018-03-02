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
	
	public function actionModalParticipar(){
		$this->tarefa = new Tarefa($this->id);
		$this->setView('tarefa/modalParticipar');
		return true;
	}
	
	public function actionModalDesistir(){
		$this->atribuicao = new Atribuicao($this->id);
		$this->tarefa = $this->atribuicao->getTarefa();
		$this->setView('tarefa/modalDesistir');
		return true;
	}
	
	public function actionAtribuir(){
		$atribuicao = new Atribuicao();
		$atribuicao->set('tarefa_id', $this->id);
		$atribuicao->set('voluntario_id', Session::getVoluntario('id'));
		$atribuicao->set('concluida', 0);
		$atribuicao->create();
		
		return false;		
	}
	
	public function actionDesistir(){
		$atribuicao = new Atribuicao($this->id);
		$atribuicao->delete();
		return false;
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

		$inicio = Globals::getDate('data_agendada_inicio');
		$fim = Globals::getDate('data_agendada_fim');		
		$filters[] = $inicio? "data_agendada >= '$inicio'" : "TRUE";
		$filters[] = $fim? "data_agendada <= '$fim'" : "TRUE";

		$inicio = Globals::getDate('data_fechamento_inicio');
		$fim = Globals::getDate('data_fechamento_fim');
		$filters[] = $inicio? "data_fechamento >= '$inicio'" : "TRUE";
		$filters[] = $fim? "data_fechamento <= '$fim'" : "TRUE";
		
		$filters[] = $status? "status = '$status'" : "TRUE";
				
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
		$this->tarefa->set('efetivacao', Globals::post('efetivacao')? '1' : '0');
		$this->tarefa->set('data_fechamento', Globals::postDate('data_fechamento'));
		$this->tarefa->set('data_agendada', Globals::postDate('data_agendada'));
		
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
				
				if ($this->tarefa->get('efetivacao') && $atribuicao->get('concluida'))			
					$atribuicao->getVoluntario()->efetivar($this->tarefa->get('evento_id'));			
				
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
		
		if ($this->tarefa->get('efetivacao'))
			foreach ($this->tarefa->getAtribuicoes() as $atribuicao)
				if ($atribuicao->get('concluida'))
					
	
		return false;
	
	}
	
	public function actionDelete(){
		$tarefa = new Tarefa($this->id);
		$tarefa->delete();
		return false;
	}
	
}