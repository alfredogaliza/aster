<?php
class AcaoController extends Controller {
	
	
	public $id = NULL;	
	
	/**
	 * Construtor do controlador
	 * @param unknown $action Nome da ação a ser executada
	 */
	public function __construct($action){
		parent::__construct("acao", $action);
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
		
		$filter = implode (" AND ", $filters);
		$offset = "OFFSET ".($page-1)*20;
		
		$this->acoes = Acao::getAll("", "$filter LIMIT 20 $offset");
		$this->setView('acao/table');
		return true;
	}
	
	
	
	/**
	 * Apresenta o modal com os dados do voluntário a ser editado/criado
	 * @return boolean
	 */
	public function actionModal(){
		$this->acao = new Acao($this->id);		
		$this->setView("acao/modal");
		return true;
	}
	
	/**
	 * Cadastra ou Altera os dados de um voluntário
	 * @return boolean
	 */
	public function actionGravar(){
			
		$this->acao = new Acao($this->id);
		$this->acao->setAttrs($_POST);
		$this->acao->update();
	
		return false;
	
	}	
	
}