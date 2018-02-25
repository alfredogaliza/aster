<?php

class PerfilController extends Controller {

	public $id       = NULL;
	public $perfil  = NULL;
	
	public function __construct($action){
		parent::__construct("perfil", $action);
		Session::start();	
		
		$this->id = Globals::get('id');
	}
	/**
	 * Apresenta a tabela de usuários filtrada e paginada pelos parâmetros repassados
	 * @return boolean
	 */
	public function actionTable(){
		$filters = [];
		$page = Globals::post('page', Globals::get('page', 1));
	
		$filters[] = ($descricao = Globals::get('descricao'))? "descricao LIKE'%$descricao%'" : "TRUE";
	
		$filter = implode (" AND ", $filters);
		$offset = "OFFSET ".($page-1)*20;
	
		$this->perfis = Perfil::getAll("", "$filter LIMIT 20 $offset");
		$this->setView('perfil/table');
		return true;
	}
	
	
	
	/**
	 * Apresenta o modal com os dados do voluntário a ser editado/criado
	 * @return boolean
	 */
	public function actionModal(){
		$this->perfil = new Perfil($this->id);
		$this->setView("perfil/modal");
		return true;
	}
	
	/**
	 * Cadastra ou Altera os dados de um voluntário
	 * @return boolean
	 */
	public function actionGravar(){
			
		$this->perfil = new Perfil($this->id);
		$this->perfil->setAttrs($_POST);
		$this->perfil->update();
		
		$this->perfil->updateRecursos(Globals::post('recurso_id', []));
	
		return false;
	
	}
	
	public function actionDelete(){
		$perfil = new Perfil($this->id);
		$perfil->delete();
		return false;
	}
		
}