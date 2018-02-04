<?php
require_once 'lib/Controller.php';
require_once 'lib/Session.php';
require_once 'lib/Globals.php';

require_once 'model/Usuario.php';



class UsuarioController extends Controller {
	
	public $id = NULL;
	public $usuario = NULL;
	public $msg = NULL;
	
	public function __construct($action){
		parent::__construct("usuario", $action);
		Session::start();

		$this->id = isset($_GET['id'])? $_GET['id'] : NULL;
		$this->usuario = new Usuario($this->id);	
		$this->msg = Globals::get('msg');	
	}
	
	public function actionConfirm(){		
		echo (strtoupper($this->usuario->get('senha')) == strtoupper(md5(Globals::get('senha'))))? "1" : "";
		return false;
	}
	
	public function actionExclude(){
		$this->usuario->set('ativo', 0);
		$this->usuario->set('bloqueado', 1);
		$this->usuario->update();
		return false;
	}	
	
	public function actionModal(){
		$this->setView('modal');
		return true;
	}
	
	public function actionSenha(){
		$this->setView('senha');
		return true;
	}
	
	public function actionNovasenha(){
		
		$senha = Globals::post('senha');
		$novasenha = Globals::post('novasenha');
		
		$usuario = Session::getUsuario();
		$usuario->read();
		
		if (strtoupper(md5($senha)) == strtoupper($usuario->get('senha'))){
			$usuario->set('senha', strtoupper(md5($novasenha)));
			$usuario->update();
			Session::set('usuario', $usuario);
			Controller::dispatch('usuario', 'senha', NULL, array('msg'=>'success'));
		} else {
			Controller::dispatch('usuario', 'senha', NULL, array('msg'=>'fail'));
		}
		
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