<?php
require_once 'lib/Controller.php';
require_once 'lib/Session.php';
require_once 'lib/Globals.php';
require_once 'model/Solicitacao.php';
require_once 'model/Andamento.php';
require_once 'model/Boleto.php';


class UploadController extends Controller {
	
	public $id = NULL;
	public $upload = NULL;
	
	public function __construct($action){
		parent::__construct("upload", $action);
		Session::start();
		
		$this->id = isset($_GET['id'])? $_GET['id'] : NULL;
		$this->upload = new Model("upload", $this->id, true);
		$this->solicitacao = new Solicitacao(Globals::post('solicitacao_id'));
	}
	
	public function actionDelete(){
		$this->upload->delete();		
		Controller::dispatch("admin", "upload", 0, array("msg"=>"success"));
	}
	
	public function actionProjetoModal(){
		$this->setView('projeto');
		return true;
	}
	
	public function actionComprovante(){
		
		$boleto = new Boleto(Globals::get('boleto_id'));		
		$arquivo = isset($_FILES['arquivo'])? $_FILES['arquivo'] : false;
		$tipo = Globals::get('tipo');
		
		if ($arquivo){
			
			if ($arquivo['size'] > Config::MAX_UPLOAD_SIZE || $arquivo['error']) {
				
				Controller::dispatch("solicitacao", "info", $boleto->get('solicitacao_id'));
				
			} else {
				
				$anexo = new Model('upload');
				$anexo->set('solicitacao_id', $boleto->get('solicitacao_id'));
				$anexo->set('nome', basename($arquivo['name']));
				$anexo->set('descricao', "Comprovante de Pagamento/Isenção");
				$anexo->create();
				
				$uploadfile = Config::UPLOAD_DIR_ANEXO . $anexo->get('id');
				if (move_uploaded_file($arquivo['tmp_name'], $uploadfile)){
					
					// Atualiza REGIN
					$solicitacao = $boleto->getSolicitacao();
					
					//if ($solicitacao->get('canal') == Config::CANAL_REGIN){
						$servico = $solicitacao->getServico();
					
						if ($servico->get('grupo') == Config::GRUPO_SERVICO_ISENCAO_REGIN){
							//FIXME: Certificar Declaração de Isenção
							$solicitacao->certificar('Emitido automaticamente após pagamento de taxa.');
						} else if ($servico->get('grupo') == Config::GRUPO_SERVICO_ACPS_REGIN){
							//FIXME: Certificar Auto de Conformidade de Processo Simplificado
							$solicitacao->certificar('Emitido automaticamente após pagamento de taxa.');
						} else if ($servico->get('grupo') == Config::GRUPO_SERVICO_VISTORIA_REGIN){
							//FIXME: Não realiza nenhuma ação, apenas atualiza o pagamento para atribuição.
						} else if ($servico->get('grupo') == Config::GRUPO_SERVICO_PROJETO_REGIN){
							//FIXME: Não realiza nenhuma ação, apenas atualiza o pagamento para atribuição.
						} else {
							//FIXME: Não realiza nenhuma ação, apenas atualiza o pagamento para atribuição.
						}
					//}
					
					if ($tipo == "baixar")
						Controller::dispatch("boleto", "baixar", $boleto->get('id'));
					else if ($tipo = "isentar"){
						Controller::dispatch("boleto", "isentar", $boleto->get('id'));
					}
					
					
				} else {
					$anexo->delete();
					//Controller::dispatch("solicitacao", "info", $boleto->get('solicitacao_id'), array("msg"=>"fail"));
					die;
				}				
			}
		}
		
		return false;
		
	}
	
	public function actionProjeto(){
		
		$arquivo = isset($_FILES['arquivo'])? $_FILES['arquivo'] : false;
	
		if ($arquivo){
				
			if ($arquivo['size'] > Config::MAX_UPLOAD_SIZE || $arquivo['error']) {
	
				Controller::dispatch("solicitacao", "info", Globals::post('solicitacao_id'));
	
			} else {
	
				$anexo = new Model('upload');
				$anexo->set('solicitacao_id', Globals::post('solicitacao_id'));
				$anexo->set('nome', basename($arquivo['name']));
				$anexo->set('descricao', "Projeto para análise");
				$anexo->set('projeto', "1");
				$anexo->create();
	
				$uploadfile = Config::UPLOAD_DIR_ANEXO . $anexo->get('id');
				if (!move_uploaded_file($arquivo['tmp_name'], $uploadfile)){
					Controller::dispatch("solicitacao", "info", Globals::post('solicitacao_id'), array("msg"=>"fail"));
				} else {
					Controller::dispatch("solicitacao", "info", Globals::post('solicitacao_id'), array("msg"=>"success"));
				}
				
			}
		}
	
		return false;
	
	}	
	
	
	public function actionDownload(){
		$filename = Config::UPLOAD_DIR_ANEXO.$this->upload->get('id'); 
		if (file_exists($filename)){
			header('Content-Description: ' . $this->upload->get('descricao'));
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="' . $this->upload->get('nome').'"');
			header('Content-Transfer-Encoding: binary');
			header('Connection: Keep-Alive');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
			header('Content-Length: ' . filesize($filename));			
			
			ob_clean();
            flush();
            readfile($filename);
            exit;
            
		} else {			
			//header("Content-type: text/html", true, 500);
			die("Falha na recupera&ccedil;&atilde;o do arquivo");
			return false;
		}
	}
	
	public function actionSefa(){
		
		$this->count = 0;
		$this->msg = "";
		
		if ($_FILES){
			
			$uploadfile = Config::UPLOAD_DIR_SEFA . date('YmdHis');

			$this->msg = "fail";
			
			if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $uploadfile)) {
			    $file = fopen($uploadfile, "r");
			    
			    while ($row = fgetcsv($file, 100, ';')){	
			    	if (preg_match("#^\d+/\d+/\d+$#", $row[0]) && preg_match("#^\d+$#", $row[1])){
			    		
			    		$data_pagamento = preg_replace("#(\d+)/(\d+)/(\d+)#", "$3-$2-$1", $row[0]);
			    		
			    		$sql = "UPDATE boleto SET data_pagamento = '$data_pagamento' WHERE id = '{$row['1']}' AND data_pagamento IS NULL";
			    		Connection::query($sql);
			    		
			    		if (Connection::affectedRows()){
			    			
			    			$this->count++;
			    			
			    			$sql = "SELECT s.id AS id, s.canal as canal
			    					FROM boleto b
			    					LEFT JOIN solicitacao s
			    						ON b.solicitacao_id = s.id
			    					WHERE b.id = '{$row['1']}'";
			    			
			    			Connection::query($sql);
			    			
			    			if ($solicitacao = Connection::next()){
			    				Andamento::auto(
			    						$solicitacao['id'],
			    						Config::DESPACHO_BOLETO_PAGO,
			    						$row[0]. " ". $row[1]
			    				);			    				
			    				//if ($solicitacao['canal'] == Config::CANAL_REGIN){
			    				
			    					$solicitacao = new Solicitacao($solicitacao['id']);			    					
			    					$servico = $solicitacao->getServico();
			    					
			    					if ($servico->get('grupo') == Config::GRUPO_SERVICO_ISENCAO_REGIN){
			    						//FIXME: Certificar Declaração de Isenção
			    						$solicitacao->certificar('Emitido automaticamente após pagamento de taxa.');
			    					} else if ($servico->get('grupo') == Config::GRUPO_SERVICO_ACPS_REGIN){
			    						//FIXME: Certificar Auto de Conformidade de Processo Simplificado
			    						$solicitacao->certificar('Emitido automaticamente após pagamento de taxa.');
			    					} else if ($servico->get('grupo') == Config::GRUPO_SERVICO_VISTORIA_REGIN){
			    						//FIXME: Não realiza nenhuma ação, apenas atualiza o pagamento para atribuição. 
			    					} else if ($servico->get('grupo') == Config::GRUPO_SERVICO_PROJETO_REGIN){
			    						//FIXME: Não realiza nenhuma ação, apenas atualiza o pagamento para atribuição.
			    					} else {
			    						//FIXME: Não realiza nenhuma ação, apenas atualiza o pagamento para atribuição.
			    					}
			    				//}
			    			}
			    		}
			    		
			    	}
			    	$this->msg = "success";			    		    	
			    }
			    fclose($file);
			}
			
			$sql = "UPDATE solicitacao s LEFT JOIN solicitacao_status_pagamento ssp 
					ON ssp.solicitacao_id = s.id SET s.status_pagamento = ssp.status";
			Connection::query($sql);
			
		}
		
		$this->setView('sefa');
		return true;
		
	}
	
	public function actionGravar(){
		$_POST['datahora'] = date("Y-m-d H:i:s");
		$this->upload  = Model::load("upload", $_POST);
		$this->upload->update();
		Controller::dispatch("admin", "solicitacao", 0, array("msg"=>"success")) ;
		return false;
	}
	
}
