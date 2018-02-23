<?php


class CadastroController extends Controller {
	
	const ERRO_DUPLICIDADE 	= 1;
	const ERRO_GERAL 		= 2;
	const ERRO_RECUPERACAO 	= 3;
	const ERRO_EMAIL 		= 4;
	const ERRO_MAILER 		= 5;
	const ERRO_CONFIRMACAO	= 6;
		
	const OK_CONFIRMADO			= 1;
	const OK_ALTERADO			= 2;
	const OK_CADASTRADO			= 3;
	const OK_EMAIL_CADASTRO		= 4;
	const OK_EMAIL_RECUPERACAO 	= 5;	
	
	public $id = NULL;	
	
	/**
	 * Construtor do controlador
	 * @param unknown $action Nome da ação a ser executada
	 */
	public function __construct($action){
		parent::__construct("cadastro", $action);
		Session::start();

		$this->id = Globals::get('id');
		$this->title = "";
		$this->msg = "";		
	}
	
	/**
	 * Exibe o formulário de Cadastro de Voluntário
	 * @return boolean
	 */
	public function actionForm(){
		$this->voluntario = Session::getVoluntario();
		$this->setView('cadastro/form');
		return true;
	}
	
	/**
	 * Recebe o formulário de cadastro de voluntário e grava as informações
	 * @return boolean
	 */
	public function actionGravar(){
		
		$nome = mb_strtoupper(Globals::post('nome'),'utf-8');
		$email = Globals::post('email1');
		$cpf = Globals::post('cpf');
		
		$senha = strtoupper(md5(rand()));
		
		$this->voluntario = new Voluntario($id);
		$this->voluntario->setAttrs($_POST);
				
		$this->voluntario->set('perfil_id', Perfil::ID_VOLUNTARIO);
		$this->voluntario->set('nome', $nome);
		$this->voluntario->set('email', $email);
		$this->voluntario->set('data_nascimento', Globals::postDate('data_nascimento'));
		$this->voluntario->set('senha', $senha);
		$this->voluntario->set('confirmado', 0);
		$this->voluntario->set('ativo', 1);
		
		if ($this->voluntario->create()){

			$this->voluntario->updateAcoes(Globals::post('acao_id', []));
			
			$link = "<a href='".Controller::route(
					'cadastro',
					'confirmar',
					$this->voluntario->get('id'),
					['q'=>$senha])."'>Link para confirmação de cadastro</a>";
			
			Session::set('email', $email);
			$mailer = new Mail([$nome=>$email], "[Instituto Áster] Confirmação de Cadastro", $link);
			
			Session::set('voluntario', $this->voluntario);
			
			if ($mailer->send()){				
				self::dispatch('cadastro', 'success', self::OK_CADASTRADO);
			} else {				
				self::dispatch('cadastro', 'fail', self::ERRO_MAILER);
			}
			
		} else {
			Session::set('voluntario', $this->voluntario);
			self::dispatch('cadastro', 'fail', self::ERRO_GERAL);
		}
		
		return false;
		
	}
	
	/**
	 * Confirma o link de confirmação e apresenta o formulário de alteração de senha
	 * para primeiro cadastro
	 * @return boolean
	 */
	public function actionConfirmar(){
	
		Session::restart();
	
		$id = Globals::get('id');
		$senha = Globals::get('q');
	
		if ($voluntarios = Voluntario::getAll('',"id='$id' AND senha='$senha' AND ativo AND NOT confirmado LIMIT 1")){
			$this->voluntario = $voluntarios[0];
			$this->setView('cadastro/formSenha');
			return true;
		} else {
			self::dispatch('cadastro', 'fail', self::ERRO_CONFIRMACAO);
			return false;
		}
	
	}	
	
	/**
	 * Exibe o modal com o formulário para inserção do email de recuperação de senha
	 * @return boolean
	 */
	public function actionModalEmail(){
		$this->setView('cadastro/modalEmail');
		return true;
	}
	
	/**
	 * Recebe o valor do email para recuperação de senha e realiza o envio do link
	 * @return boolean
	 */
	public function actionEmailRecuperacao(){		
		
		$email = Globals::post('email');
		
		if ($voluntarios = Voluntario::getAll('',"ativo AND email='$email' LIMIT 1")){
			
			$this->voluntario = $voluntarios[0];
			
			$nome = $this->voluntario->get('nome');
			$senha = $this->voluntario->get('senha');

			//TODO: Criar uma página Template com o modelo de email 
			$link = "<a href='".Controller::route(
					'cadastro',
					'formSenha',
					$this->voluntario->get('id'),
					['q'=>$senha])."'>Link para Recuperação de Senha</a>";
			
			$mailer = new Mail([$nome=>$email], '[Insitituto Áster] Recuperação de Senha', $link);
			
			if ($mailer->send()){
				Session::set('email', $email);
				self::dispatch('cadastro', 'success', self::OK_EMAIL_RECUPERACAO);
			} else {
				//self::dispatch('cadastro', 'fail', self::ERRO_MAILER);
			}
								
		} else {
			//self::dispatch('cadastro', 'fail', self::ERRO_EMAIL);
		}
		
		return false;
	}
	
	/**
	 * Confirma o link de confirmação e apresenta o formulário de alteração de senha
	 * @return boolean
	 */
	public function actionFormSenha(){
		
		Session::restart();
		
		$id = Globals::get('id');
		$senha = strtoupper(Globals::get('q'));		
		
		if ($voluntarios = Voluntario::getAll('',"id='$id' AND senha=UPPER('$senha') AND ativo")){
			$this->voluntario = $voluntarios[0];									
			$this->setView('cadastro/formSenha');
			return true;
		} else {
			self::dispatch('cadastro', 'fail', self::ERRO_RECUPERACAO);
			return false;
		}
				
	}

	/**
	 * Altera a senha do usuário atual e encaminha para realizar um novo login
	 * @return boolean
	 */
	public function actionNovaSenha(){
		
		Session::restart();
	
		$senha1 = Globals::post('senha1');
		$senha2 = Globals::post('senha2');
		$oldsenha = Globals::post('old_senha');	
		$voluntario = new Voluntario(Globals::post('id'));
		
		if ($senha1 == $senha2 && $oldsenha == $voluntario->get("senha")){
			$voluntario->set('senha', mb_strtoupper(md5($senha1)),'utf-8');
			$voluntario->set('confirmado', 1);
			$voluntario->update();
			Controller::dispatch('login', 'logoff', NULL, array('msg'=>'senha'));
		} else {
			self::dispatch('cadastro', 'fail', self::ERRO_RECUPERACAO);
		}		
	
		return false;
	}	
	
	/**
	 * Exibe a página de falha, de acordo com o parâmetro id de Erro
	 * @return boolean
	 */
	public function actionFail(){
		switch ($this->id){
			case  self::ERRO_DUPLICIDADE:
				$this->msg = "O CPF ou email informado já se encontra em nosso sistema!";
				$this->title = "Duplicidade no cadastro";
				break;
			case self::ERRO_GERAL:
				$this->msg = "Ocorreu um erro em nossos registros. Por favor, tente mais tarde!";
				$this->title = "Erro cadastro de voluntário";
				break;
			case self::ERRO_RECUPERACAO:
				$this->msg = "Dados Inválidos para recuperação de senha!";
				$this->title = "Erro na recuperação de senha";
				break;
			case self::ERRO_CONFIRMACAO:
				$this->msg = "Erro na confirmação do Usuário";
				$this->title = "Erro na recuperação de senha";
				break;
			case self::ERRO_EMAIL:
				$this->msg = "Email não encontrado!";
				$this->title = "Erro na recuperacao de senha";
				break;
			case self::ERRO_MAILER:
				$this->msg = "Erro na configuração de Email! Contate o administrador!";
				$this->title = "Erro no envio de Email";
				break;
			default:
				$this->msg = "É tudo o que sabemos.";
				$this->title = "Erro no processamento!";
				break;
		}
	
		$this->setView("cadastro/fail");
		return true;
			
	}
	
	/**
	 * Exibe a página de sucesso com os parâmetros de acordo com o id de OK
	 * @return boolean
	 */
	public function actionSuccess(){
	
		switch ($this->id){
			case self::OK_CADASTRADO:
				$email = Session::get('email');
				$this->msg = "Enviamos uma mensagem para $email. Acesse sua caixa de entrada e clique no link de confirmação";
				$this->title = "Cadastro recebido com sucesso";
				break;
			case self::OK_EMAIL_RECUPERACAO:
				$email = Session::get('email');
				$this->msg = "Enviamos uma mensagem para $email. Acesse sua caixa de entrada e clique no link de confirmação";
				$this->title = "Recuperação de senha solicitada";
				break;
			default:
				break;
		}
		$this->setView('cadastro/success');
		return true;
	}	
	
}