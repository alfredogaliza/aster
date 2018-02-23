<?php

class NoticiaController extends Controller {

	public function __construct($action){
		parent::__construct("noticia", $action);
		Session::start();
		
		$this->id = Globals::get('id');
	}
	
	public function actionDefault(){
		return false;
	}
	
	public function actionAjax(){
		$page = Globals::post('page', Globals::get('page', 1));
		$filter = "TRUE ORDER BY datahora DESC LIMIT 5 OFFSET ".(($page-1)*5);
		$this->noticias = Noticia::getAll("", $filter);
		
		$this->setView('noticia/ajax');
		return true;
	}
	
	/**
	 * Apresenta a tabela de usuários filtrada e paginada pelos parâmetros repassados
	 * @return boolean
	 */
	public function actionTable(){
		$filters = [];
		$page = Globals::post('page', Globals::get('page', 1));
	
		$filters[] = ($titulo = Globals::get('titulo'))? "titulo LIKE'%$titulo%'" : "TRUE";
		
		$inicio = Globals::getDate('data_inicio');
		$fim = Globals::getDate('data_fim');
		$filters[] = $inicio? "datahora >= '$inicio'" : "TRUE";
		$filters[] = $fim? "datahora <= '$fim'" : "TRUE";
	
		$filter = implode (" AND ", $filters);
		$offset = "OFFSET ".($page-1)*20;
	
		$this->noticias = Noticia::getAll("", "$filter LIMIT 20 $offset");
		$this->setView('noticia/table');
		return true;
	}
	
	
	
	/**
	 * Apresenta o modal com os dados do voluntário a ser editado/criado
	 * @return boolean
	 */
	public function actionModal(){
		$this->noticia = new Noticia($this->id);
		$this->setView("noticia/modal");
		return true;
	}
	
	/**
	 * Cadastra ou Altera os dados de um voluntário
	 * @return boolean
	 */
	public function actionGravar(){
			
		$this->noticia = new Noticia($this->id);
		$this->noticia->setAttrs($_POST);
		$this->noticia->set('datahora', date('Y-m-d H:i:s'));
		$this->noticia->update();
	
		return false;
	
	}
	
	public function actionDelete(){
		$noticia = new Noticia($this->id);
		$noticia->delete();
		return false;
	}
	
}
