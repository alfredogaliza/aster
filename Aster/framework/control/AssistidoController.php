<?php


class AssistidoController extends Controller {
	
	
	public $id = NULL;	
	
	/**
	 * Construtor do controlador
	 * @param unknown $action Nome da ação a ser executada
	 */
	public function __construct($action){
		parent::__construct("assistido", $action);
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
		$status = Globals::get('status');
		
		$filters[] = ($sexo = Globals::get('sexo'))? "sexo = '$sexo'" : "TRUE";
		$filters[] = ($nome = Globals::get('nome'))? "nome LIKE'%$nome%'" : "TRUE";
		$filters[] = ($diagnostico = Globals::get('diagnostico'))? "diagnostico LIKE'%$diagnostico%'" : "TRUE";
		$filters[] = ($cidade = Globals::get('cidade_id'))? "cidade_id = '$cidade'" : "TRUE";

		$inicio = Globals::getDate('data_tratamento_inicio');
		$fim = Globals::getDate('data_tratamento_fim');		
		$filters[] = $inicio? "data_tratamento >= '$inicio'" : "TRUE";
		$filters[] = $fim? "data_tratamento <= '$fim'" : "TRUE";
		
		$inicio = Globals::getDate('data_atualizacao_inicio');
		$fim = Globals::getDate('data_atualizacao_fim');
		$filters[] = $inicio? "data_atualizacao >= '$inicio'" : "TRUE";
		$filters[] = $fim? "data_atualizacao <= '$fim'" : "TRUE";		
		
		$inicio = Globals::get('aniversario_inicio', '01/01');
		$fim = Globals::get('aniversario_fim', '31/12');
		$filters[] = "STR_TO_DATE('$inicio', '%d/%m') <=  STR_TO_DATE(DATE_FORMAT(data_nascimento, '%d/%m'), '%d/%m')";
		$filters[] = "STR_TO_DATE('$fim', '%d/%m') >=  STR_TO_DATE(DATE_FORMAT(data_nascimento, '%d/%m'), '%d/%m')";
		
		$filters[] = $status? "fase_tratamento='$status'" : "TRUE";
		
		$filter = implode (" AND ", $filters);
		$offset = "OFFSET ".($page-1)*20;
		
		$this->assistidos = Assistido::getAll("", "$filter LIMIT 20 $offset");
		$this->setView('assistido/table');
		return true;
	}
	
	
	
	/**
	 * Apresenta o modal com os dados do voluntário a ser editado/criado
	 * @return boolean
	 */
	public function actionModal(){
		$this->assistido = new Assistido($this->id);
		$this->responsaveis = $this->assistido->getResponsaveis();
		$this->setView("assistido/modal");
		return true;
	}
	
	/**
	 * Cadastra ou Altera os dados de um voluntário
	 * @return boolean
	 */
	public function actionGravar(){
	
		$nome = strtoupper(Globals::post('nome'));	
		$this->assistido = new Assistido($this->id);
		$this->assistido->setAttrs($_POST);
	
		$this->assistido->set('nome', $nome);
		$this->assistido->set('data_nascimento', Globals::postDate('data_nascimento'));
		$this->assistido->set('data_tratamento', Globals::postDate('data_tratamento'));
		$this->assistido->set('data_atualizacao', date('Y-m-d H:i:s'));		
		
		if ($this->assistido->update()){
			
			$responsaveis_antigos = $this->assistido->getResponsaveis();
			$assistido_id = $this->assistido->get('id');
			
			foreach (Globals::post('responsavel_id', []) as $i => $responsavel_id){				
				$responsavel = new Responsavel($responsavel_id);
				$responsavel->set('nome', strtoupper(Globals::post('responsavel_nome')[$i]));
				$responsavel->set('endereco', Globals::post('responsavel_endereco')[$i]);
				$responsavel->set('contato', Globals::post('responsavel_contato')[$i]);
				$responsavel->set('whatsapp', Globals::post('responsavel_whatsapp')[$i]);
				$responsavel->set('email', Globals::post('responsavel_email')[$i]);
				$responsavel->set('parentesco', Globals::post('responsavel_parentesco')[$i]);
				$responsavel->set('assistido_id', $assistido_id);
				$responsavel->update();
				$responsaveis_novos[] = $responsavel;
			}
			
			foreach($responsaveis_antigos as $antigo){
				$delete = true;
				foreach($responsaveis_novos as $novo){
					if ($antigo->get('id') == $novo->get('id')){
						$delete = false;
						break;
					}						
				}
				if ($delete) $antigo->delete();
			}			
									
		}
	
		return false;
	
	}	
	
}