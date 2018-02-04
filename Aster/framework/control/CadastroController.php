<?php

class CadastroController extends Controller {
	
	public function __construct($action){		
		parent::__construct("cadastro", $action);
		Session::start();
		
		$this->msg = Globals::get("msg");
	}		
	
	public function actionUsuario(){
		$this->polo_id =  Globals::get('polo_id',
				Session::getUsuario()->hasPermission('gerencia', 'global')?
				NULL : Session::getUsuario('polo_id') );
		$this->perfil_id = Globals::get('perfil_id');
		$this->nome = Globals::get('nome');
		$status = Globals::get('status');
		
	
		$polo = $this->polo_id? "polo_id = '{$this->polo_id}'" : "TRUE";
		$perfil  = $this->perfil_id? "perfil_id = '{$this->perfil_id}'" : "TRUE";		
		$nome    = $this->nome? "nome LIKE '%{$this->nome}%'" : "TRUE";
		$status = $status? "status = '$status'" : 'TRUE';
		$filter = "$polo AND $perfil AND $nome AND $status ORDER BY nome";
		
		$this->usuarios = Model::getAllRows("lista_usuario", $filter);
		
		$this->setView("usuario");
		return true;
	}
	
	
	public function actionAluno(){
		$this->polo_id =  Globals::get('polo_id', Session::getUsuario('polo_id') );
		$this->status = Globals::get('status');
		$this->nome = Globals::get('nome');
		$this->status = Globals::get('status');
		$this->responsavel = Globals::get('responsavel');
		$inclusao1 = Globals::getDate('inclusao1');
		$inclusao2 = Globals::getDate('inclusao2');
		
	
		$responsavel = $this->responsavel? "responsaveis LIKE '%{$this->responsavel}%'" : "TRUE";
		$polo = $this->polo_id? "polo_id = '{$this->polo_id}'" : "TRUE";
		$status  = $this->status? "status = '{$this->status}'" : "TRUE";
		$nome    = $this->nome? "nome LIKE '%{$this->nome}%'" : "TRUE";
		$inclusao = $inclusao1? (
				$inclusao2? "inclusao BETWEEN '$inclusao1' AND '$inclusao2'" :
				"inclusao >= '$inclusao1'"
				) : ($inclusao2? "inclusao <= '$inclusao2'" : "TRUE" );
		
		
		$filter = "$polo AND $status AND $nome AND $responsavel AND $inclusao ORDER BY nome";
	
		$this->alunos = Model::getAllRows("lista_aluno", $filter);
	
		$this->setView("aluno");
		return true;
	}
	
	public function actionTurma(){
		
		$polo_id =  Globals::get('polo_id', Session::getUsuario('polo_id') );
		$status = Globals::get('status');
		$descricao = Globals::get('descricao');		
		$emcurso = Globals::getDate('emcurso');
		$observacao = Globals::get('observacao');
	
		$polo = $polo_id? "polo_id = '$polo_id'" : "TRUE";
		$status  = $status? "status = '$status'" : "TRUE";
		$descricao    = $descricao? "descricao LIKE '%$descricao%'" : "TRUE";
		$observacao    = $observacao? "descricao LIKE '%$observacao%'" : "TRUE";
		$emcurso = $emcurso? "'$emcurso' BETWEEN inicio AND termino" : "TRUE" ;
	
		$filter = "$polo AND $status AND $descricao AND $observacao AND $emcurso ORDER BY polo_id, inicio DESC";
	
		$this->turmas = Model::getAllRows("lista_turma", $filter);
	
		$this->setView("turma");
		return true;
		
	}
	
	public function actionMatricula(){
	
		$polo_id  = Globals::get('polo_id', Session::getUsuario('polo_id') );
		$turma_id = Globals::get('turma_id');
		$aluno    = Globals::get('aluno');
		$status   = Globals::get('status');
	
		$polo = $polo_id? "polo_id = '$polo_id'" : "TRUE";
		$turma = $turma_id? "turma_id = '$turma_id'" : "TRUE";
		$status  = $status? "status = '$status'" : "TRUE";
		$aluno    = $aluno? "aluno_nome LIKE '%$aluno%'" : "TRUE";
		
	
		$filter = "$polo AND $turma AND $status AND $aluno ORDER BY turma_id, aluno_nome";
	
		$this->matriculas = Model::getAllRows("lista_matricula", $filter);
	
		$this->setView("matricula");
		return true;
	
	}
	
	
}