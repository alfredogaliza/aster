<?php
require_once 'lib/Controller.php';
require_once 'lib/Session.php';
require_once 'lib/Globals.php';

require_once 'model/Aluno.php';



class InscricaoController extends Controller {
	
	public $id = NULL;
	public $aluno = NULL;
	public $msg = NULL;
	
	public function __construct($action){
		parent::__construct("inscricao", $action);
		Session::start();
		$this->id = Globals::get('id');
	}
	
	public function actionDefault(){
		$this->polos = Polo::getAll('polo', 'ativo AND cadastravel');
		$this->setView('welcome');
		return true;
	}
	
	public function actionModal(){
		$this->aluno = new Aluno();
		$this->polo = new Polo(Globals::get('polo_id'));
		$this->responsaveis = [];
		$this->setView('modal');
		return true;
	}
	
	public function actionSuccess(){
		$this->aluno = new Aluno($this->id);
		$this->setView('success');
		return true;
	}
	
	public function actionFail(){
		$this->setView('fail');
		return true;
	}
	
	public function actionGravar(){
		
		Config::set('dieOnError', false);
		
		$_POST['nascimento'] = Globals::postDate('nascimento');
		$this->aluno = Model::load("aluno", $_POST);
		$this->aluno->set('inclusao', Globals::post('inclusao')? Globals::post('inclusao') : 'NOW()');
		$this->aluno->update();		
		$aluno_id = $this->aluno->get('id');
		
		$relacionamentos = [
				'aluno_atividade'=>'atividade_id',
				'aluno_saude'=>'saude_id',
				'aluno_infraestrutura'=>'infraestrutura_id',
				'disciplina_facilidade'=>'disciplina_id',
				'disciplina_dificuldade'=>'disciplina_id',
				'disciplina_dependencia'=>'disciplina_id'
		];
		
		foreach ($relacionamentos as $tabela => $chave){
			$ids = implode("','", Globals::post($tabela,[]));
			foreach(Globals::post($tabela,[]) as $id)
				Connection::query("REPLACE INTO $tabela (aluno_id, $chave) VALUES ('$aluno_id', '$id')");
			Connection::query("DELETE FROM $tabela WHERE aluno_id='$aluno_id' AND $chave NOT IN ('$ids')");
		}		
		
		$responsaveis = Globals::post('responsavel', []);
		
		$ids = implode("','", $responsaveis['id']);
		$sql = "UPDATE responsavel SET ativo = 0 WHERE id NOT IN ('$ids') AND aluno_id = '$aluno_id'";
		Connection::query($sql);
		
		foreach ($responsaveis['id'] as $i => $responsavel_id){
			$responsavel = new Model('responsavel', $responsavel_id, true);
			$responsavel->set('aluno_id', $aluno_id);
			$responsavel->set('escolaridade_id', $responsaveis['escolaridade_id'][$i]);
			$responsavel->set('nome', $responsaveis['nome'][$i]);
			$responsavel->set('tipo', $responsaveis['tipo'][$i]);
			$responsavel->set('rg', $responsaveis['rg'][$i]);
			$responsavel->set('nascimento', Config::toDateYMD($responsaveis['nascimento'][$i]));
			$responsavel->set('naturalidade', $responsaveis['naturalidade'][$i]);
			$responsavel->set('endereco', $responsaveis['endereco_residencial'][$i]);
			$responsavel->set('tel_residencial', $responsaveis['tel_residencial'][$i]);
			$responsavel->set('tel_celular', $responsaveis['tel_celular'][$i]);
			$responsavel->set('tel_trabalho', $responsaveis['tel_trabalho'][$i]);
			$responsavel->set('profissao', $responsaveis['profissao'][$i]);
			$responsavel->set('profissao_endereco', $responsaveis['endereco_profissional'][$i]);
			$responsavel->set('ativo', 1);
			$responsavel->update();
		}
		
		$this->aluno->updateStatus();
		
		Controller::dispatch("inscricao", $this->aluno->get('id')? 'success' : 'fail', $this->aluno->get('id'));		
		return false;
		
	}
	
}