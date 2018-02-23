<?php

class AgendaController extends Controller {

	public function __construct($action){
		parent::__construct("agenda", $action);
		Session::start();
	}
	
	public function actionDefault(){
		return false;
	}
	
	public function actionAtualizacao(){
		header("Content-type: text/json");
		return false;
		
		
		echo
			'[
				{
					"date": "2018-02-10",
					"title": "Nome do Evento",
					"classname": "Nome da classe",
					"badge": true,
					"body": "Conteúdo",
					"modal": true,
					"popover": true
				},
				{
					"date": "2018-02-13",
					"title": "Nome do Evento",
					"classname": "bg-info",
					"badge": false,
					"body": "Conteúdo",
					"modal": true,
					"popover": true
				},
				{
					"date": "2018-02-15",
					"title": "Nome do Evento",
					"classname": "bg-info",
					"badge": true,
					"body": "Conteúdo",
					"modal": true,
					"popover": true
				}				
			]';
		return false;	
	}
	
}
