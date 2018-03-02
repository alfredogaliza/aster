<?php


class ResponsavelController extends Controller {
	
	
	public $id = NULL;	
	
	/**
	 * Construtor do controlador
	 * @param unknown $action Nome da ação a ser executada
	 */
	public function __construct($action){
		parent::__construct("responsavel", $action);
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
		
		$filters[] = ($nome = Globals::get('nome'))? "nome LIKE'%$nome%'" : "TRUE";
		$filters[] = ($nome = Globals::get('parentesco'))? "parentesco LIKE'%$nome%'" : "TRUE";		
		
		$filter = implode (" AND ", $filters);
		$offset = "OFFSET ".($page-1)*20;
		
		$this->responsaveis = Responsavel::getAll("", "$filter LIMIT 20 $offset");
		$this->setView('responsavel/table');
		return true;
	}
	
	
	
	/**
	 * Apresenta o modal com os dados do voluntário a ser editado/criado
	 * @return boolean
	 */
	public function actionModal(){
		$this->responsavel = new Responsavel($this->id);		
		$this->setView("responsavel/modal");
		return true;
	}
	
	/**
	 * Cadastra ou Altera os dados de um voluntário
	 * @return boolean
	 */
	public function actionGravar(){
			
		$this->responsavel = new Responsavel($this->id);
		$this->responsavel->setAttrs($_POST);
	
		$nome = mb_strtoupper(Globals::post('nome'),'utf-8');
		$this->responsavel->set('nome', $nome);
		$this->responsavel->update();
	
		return false;
	
	}
	
	public function actionDelete(){
		$model = new Responsavel($this->id);
		$model->delete();
		return false;
	}
	
}