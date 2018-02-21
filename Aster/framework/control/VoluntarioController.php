<?php


class VoluntarioController extends Controller {
	
	
	public $id = NULL;	
	
	/**
	 * Construtor do controlador
	 * @param unknown $action Nome da ação a ser executada
	 */
	public function __construct($action){
		parent::__construct("voluntario", $action);
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
		
		$filters[] = ($sexo = Globals::get('sexo'))? "sexo = '$sexo'" : "TRUE";
		$filters[] = ($nome = Globals::get('nome'))? "nome LIKE'%$nome%'" : "TRUE";
		$filters[] = ($formacao = Globals::get('formacao'))? "formacao LIKE'%$formacao%'" : "TRUE";
		$filters[] = ($perfil = Globals::get('perfil_id'))? "perfil_id = '$perfil'" : "TRUE";
		
		if ($doador_sangue = Globals::get('doador_sangue')){
			switch ($doador_sangue){
				case 'N':
					$filters[] = "NOT doador_sangue";
					break;
				case 'D':
					$filters[] = "doador_sangue";
					break;
				default:
					$filters[] = "doador_sangue AND tipo_sanguineo = '$doador_sangue'";
					break;
			}
		}
		
		if ($doador_medula = Globals::get('doador_medula')){
			switch ($doador_sangue){
				case 'N':
					$filters[] = "NOT doador_medula";
					break;
				case 'D':
					$filters[] = "doador_medula";
					break;
			}
		}
		
		$inicio = Globals::get('aniversario_inicio', '01/01');
		$fim = Globals::get('aniversario_fim', '31/12');
		$filters[] = "STR_TO_DATE('$inicio', '%d/%m') <=  STR_TO_DATE(DATE_FORMAT(data_nascimento, '%d/%m'), '%d/%m')";
		$filters[] = "STR_TO_DATE('$fim', '%d/%m') >=  STR_TO_DATE(DATE_FORMAT(data_nascimento, '%d/%m'), '%d/%m')";
		
		switch (Globals::get('status')){
			case Voluntario::STATUS_NOTEFFECTIVE:
				$filters[] = "ativo AND confirmado AND evento_id IS NULL";
				break;
			case Voluntario::STATUS_OK:
				$filters[] = "ativo AND confirmado AND evento_id";
				break;
			case Voluntario::STATUS_CONFIRM:
				$filters[] = "ativo AND NOT confirmado";
				break;
			case Voluntario::STATUS_BLOCK:
				$filters[] = "NOT ativo";
				break;
		}
		
		$filter = implode (" AND ", $filters);
		$offset = "OFFSET ".($page-1)*20;
		
		$this->voluntarios = Voluntario::getAll("", "$filter LIMIT 20 $offset");
		$this->setView('voluntario/table');
		return true;
	}
	
	public function actionBlock(){
		$voluntario = new Voluntario($this->id);
		$voluntario->set('ativo', 0)->update();		
		return false;
	}
	
	public function actionUnblock(){
		$voluntario = new Voluntario($this->id);
		$voluntario->set('ativo', 1)->update();
		return false;
	}
	
	/**
	 * Apresenta o modal com os dados do voluntário a ser editado/criado
	 * @return boolean
	 */
	public function actionModal(){
		$this->voluntario = new Voluntario($this->id);
		$this->setView("voluntario/modal");
		return true;
	}
	
	/**
	 * Cadastra ou Altera os dados de um voluntário
	 * @return boolean
	 */
	public function actionGravar(){
	
		$nome = strtoupper(Globals::post('nome'));
	
		$this->voluntario = new Voluntario($this->id);
		$this->voluntario->setAttrs($_POST);
	
		$this->voluntario->set('nome', $nome);
		$this->voluntario->set('data_nascimento', Globals::postDate('data_nascimento'));
	
		if ($this->voluntario->update()){	
			$this->voluntario->updateAcoes(Globals::post('acao_id', []));										
		}
	
		return false;
	
	}
	

	/**
	 * Apresenta o formulário de alteração de senha
	 * para primeiro cadastro
	 * @return boolean
	 */
	public function actionSenha(){	
		$this->voluntario = Session::getVoluntario();
		$this->setView('voluntario/formSenha');
		return true;	
	}
	
	/**
	 * Altera a senha do usuário atual e encaminha para realizar um novo login
	 * @return boolean
	 */
	public function actionNovaSenha(){
	
		$senha1 = Globals::post('senha1');
		$senha2 = Globals::post('senha2');
		$oldsenha = strtoupper(md5(Globals::post('old_senha')));
		$voluntario = new Voluntario(Globals::post('id'));
	
		if ($senha1 == $senha2 && $oldsenha == $voluntario->get("senha")){
			$voluntario->set('senha', strtoupper(md5($senha1)));
			$voluntario->set('confirmado', 1);
			$voluntario->update();
			Controller::dispatch('login', 'logoff', NULL, array('msg'=>'senha'));
		} else {
			self::dispatch('cadastro', 'fail', CadastroController::ERRO_RECUPERACAO);
		}
	
		return false;
	}	
	
}