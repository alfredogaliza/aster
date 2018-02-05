<?php


class VoluntarioController extends Controller {
	
	public $id = NULL;
	
	public function __construct($action){
		parent::__construct("voluntario", $action);
		Session::start();

		$this->id = Globals::get('id');		
	}
	
	
	public function actionCadastro(){
		$this->setView('voluntarioForm');
		return true;
	}
	
	public function actionCadastrar(){
		
		$nome = Globals::post('nome');
		$email = Globals::post('email1');
		$cpf = Globals::post('cpf');
		
		if (Model::getAll('voluntario', "cpf='$cpf' OR email='$email'")){
			$this->msg = "duplicidade";
			$this->setView('voluntarioPageFail');
			return true;
		}
		
		$senha = strtoupper(md5(rand()));
		
		$this->voluntario = Model::load("voluntario", $_POST);		
		$this->voluntario->set('id', NULL);
		$this->voluntario->set('perfil_id', Perfil::ID_VOLUNTARIO);
		$this->voluntario->set('email', $email);
		$this->voluntario->set('data_nascimento', Globals::postDate('data_nascimento'));
		$this->voluntario->set('senha', $senha);
		$this->voluntario->set('confirmacao', 1);
		
		if ($this->voluntario->create()){		
			
			$link = "<a href='".Controller::route(
					'voluntario',
					'recuperar',
					$this->voluntario->get('id'),
					['q'=>$senha])."'>Link para confirmação de cadastro</a>";
			
			$mailer = new Mail([$nome=>$email], $link);
			
			if ($mailer->send()){
				echo $link;
				$this->setView('voluntarioPageSuccess');
			} else {
				$this->msg = "mailer";
				$this->setView('voluntarioPageFail');
			}
			
		} else {
			$this->msg = "erro";
			$this->setView('voluntarioPageFail');
		}
		
		return true;
		
	}
	
	public function actionRecuperacao(){
		$this->setView('recuperacaoModal');
		return true;
	}
	
	public function actionEmail(){		
		
		Session::destroy();
		
		$email = Globals::post('email');
		if ($voluntarios = Usuario::getAll('',"email='$email' LIMIT 1")){
			
			$this->voluntario = $voluntarios[0];
			
			$nome=$this->voluntario->get('nome');
			$email=$this->voluntario->get('email');

			//$senha = strtoupper(md5(rand()));
			$senha = $this->voluntario->get('senha');
						
			$this->voluntario->set('senha', $senha);
			$this->voluntario->set('confirmacao', 1);
			$this->voluntario->update();

			$link = "<a href='".Controller::route(
					'voluntario',
					'recuperar',
					$this->voluntario->get('id'),
					['q'=>$senha])."'>Link para confirmação de cadastro</a>";
			
			$mailer = new Mail([$nome=>$email], 'Confirmação de Cadastro', $link);
			
			if ($mailer->send()){
				$this->setView('voluntarioPageSuccess');
			} else {
				$this->msg = "mailer";
				$this->setView('voluntarioPageFail');
			}
								
		} else {
			$this->msg = "email";
			$this->setView('voluntarioPageFail');
		}
		return true;
	}
	
	public function actionRecuperar(){
		
		Session::destroy();
		Session::start();
		
		$id = Globals::get('id');
		$senha = strtoupper(Globals::get('q'));		
		
		if ($voluntarios = Usuario::getAll('',"id='$id' AND senha=UPPER('$senha') AND confirmacao")){
			$this->voluntario = $voluntarios[0];			
			Session::set('usuario', $this->voluntario);							
			$this->setView('senhaForm');
		} else {
			$this->msg = "recuperacao";
			$this->setView("voluntarioPageFail");
		}
		
		return true;
	}	
	
	public function actionNovasenha(){
		
		$senha = Globals::post('senha1');
		
		$usuario = Session::getUsuario();
		$usuario->read();
		
			
		$usuario->set('senha', strtoupper(md5($senha)));
		$usuario->set('confirmacao', 0);
		$usuario->update();
	
		Controller::dispatch('login', 'logoff', NULL, array('msg'=>'senha'));
		
		return false;
	}
	
	public function actionBlock(){
		$this->usuario->block();		
		Controller::dispatch("cadastro", "usuario", NULL, array('msg'=>'success'));
		return false;
	}
	
	public function actionUnblock(){
		$this->usuario->unblock();	
		Controller::dispatch("cadastro", "usuario", NULL, array('msg'=>'success'));
		return false;
	}
	
	public function actionReset(){
		$this->usuario->reset();		
		Controller::dispatch("cadastro", "usuario", NULL, array("msg"=>'success'));
		return false;
	}	
	
	public function actionGravar(){
		if (!$_POST['id']) $_POST['senha'] = md5("12345");	
		
		$this->usuario = Model::load("usuario", $_POST);
		$this->usuario->set('ultimo_login', NULL);
		$this->usuario->update();		
		Controller::dispatch("cadastro", "usuario", NULL, array("msg"=>'success'));
		return false;
	}
	
	public function actionLogout(){
		Session::destroy();
		Controller::dispatch("login");
		return false;
	}

	
}