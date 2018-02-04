<?php
require_once 'lib/Controller.php';
require_once 'lib/Session.php';
require_once 'lib/Globals.php';
require_once 'lib/PDF.php';

require_once 'model/Certificado.php';
require_once 'model/Polo.php';
require_once 'model/Boleto.php';
require_once 'model/Atribuicao.php';
require_once 'model/Servico.php';

class RelatorioController extends Controller {
	
	public $rows = array();
	
	public function __construct($action){
		parent::__construct("relatorio", $action);
		Session::start();
	}
	
	public function actionExtraordinaria(){
	
		$this->funcao_id = Globals::get('funcao_id', []);
		$this->unidade_id =  Globals::get('unidade_id',
				Session::getUsuario()->hasPermission('gerencia', 'global')?
				NULL : Session::getUsuario('unidade_id') );
		$this->data_execucao1 = Globals::getDate('data_execucao1');
		$this->data_execucao2 = Globals::getDate('data_execucao2');
		$this->extraordinario = Globals::get('extraordinario');
	
	
		$execucao = $this->data_execucao1? (
			$this->data_execucao2? "data_execucao BETWEEN '{$this->data_execucao1}' AND '{$this->data_execucao2} 23:59:59'" :
			"data_execucao >= '{$this->data_execucao1}'"
			) : ($this->data_execucao2? "data_execucao <= '{$this->data_execucao2} 23:59:59'" : "TRUE" );

		$funcao  = $this->funcao_id? "funcao_id IN (".implode(',',$this->funcao_id).")" : "TRUE";
		$unidade  = $this->unidade_id? "unidade_id = '{$this->unidade_id}'" : "TRUE";

		$extraordinario = $this->extraordinario? 'extraordinario = 1' : (
				is_null($this->extraordinario)? 'TRUE' : 'extraordinario = 0');

		$filter = "($execucao) AND ($funcao) AND ($unidade) AND ($extraordinario)";

		$sql = "SELECT
					unidade_sigla as unidade,
					CONCAT(usuario_graduacao, ' ', usuario_nome) as usuario,
					usuario_login as mf,
					CONCAT(LPAD(MONTH(data_execucao), 2,'0'), '/', YEAR(data_execucao)) as mes_ano,
					GROUP_CONCAT(DISTINCT funcao_descricao ORDER BY funcao_descricao SEPARATOR ',<br>') AS funcoes,
					GROUP_CONCAT(DISTINCT DAY(data_execucao) ORDER BY DAY(data_execucao)) AS dias,
					COUNT(DISTINCT DATE(data_execucao) ) AS total
				FROM
					lista_atribuicao
				WHERE
					status IN (2,3) AND $filter
				GROUP BY
					usuario_id, YEAR(data_execucao), MONTH(data_execucao)
				ORDER BY
					unidade_sigla, usuario_nome, data_execucao";


		$this->atribuicoes = Model::getAllRowsSQL($sql);

		if (Globals::get('imprimir')){
			$this->pdf = new PDF("A4-L");
			$this->pdf->showImageErrors = true;
			$this->setView("extraordinariaPDF");
		} else {
			$this->setView("extraordinaria");
		}
		
		return true;
	}	
	
	
	public function actionDinamico(){
		$this->setView('dinamico');
		return true;
	}
	
	public function actionDinamicoCampos(){
		$tabela = Globals::get('tabela');
		$sql = "DESCRIBE $tabela";
		
		$i = 0;
		Connection::query($sql);		
		while ($row = Connection::next(false)){
						
			preg_match("/^([a-zA-Z]*).*/", $row[1], $matches);
			
			switch ($matches[1]) {
				case 'number':
				case 'int':
				case 'double':
				case 'float':
					$type = 'number';
					break;			
				case 'date':
				case 'datetime':
					$type = 'date';
					break;
				default:
					$type = "text";
			}
			
			echo "<div data-value='{$row[0]}' class='list-group-item draggable' draggable='true' data-type='$type' data-id='$i'>\n";
			echo $row[0];
			echo "</div>";
			$i = $i + 1;
		}
	}
	
	public function actionDinamicoSubmit(){
		
		// Recupera os parametros da requisicao
		$linhas   = Globals::get('linha',  array());
		$colunas  = Globals::get('coluna', array());
		$valores  = Globals::get('valor',  array());
		$filtros  = Globals::get('filtro', array());		
		$mLinhas  = Globals::get('modificador_linha',  array());
		$mColunas = Globals::get('modificador_coluna', array());
		$mValores = Globals::get('modificador_valor',  array());
		$mFiltros = Globals::get('modificador_filtro', array());
		
		// Agrupa todos os arrays em um único 
		$campos = array_merge($linhas, $colunas, $valores);
		$mCampos = array_merge($mLinhas, $mColunas, $mValores);

		// Define os campos do select
		$fields = array();	
		foreach ($campos as $i => $campo) {
			switch($mCampos[$i]){
				case "day":
					$label = "DIA de $campo";
					$value = "DAY($campo)";
					break;
				case "dayofweek":
					$label = "DIA DA SEMANA de $campo";
					$value = "DAYOFWEEK($campo)";
					break;					
				case "month":
					$label = "MÊS de $campo";
					$value = "MONTH($campo)";
					break;					
				case "year":
					$label = "ANO de $campo";
					$value = "YEAR($campo)";
					break;
				case "max":
					$label = "MÁX($campo)";
					$value = "MAX($campo)";
					break;
				case "min":
					$label = "MÍN($campo)";
					$value = "MIN($campo)";
					break;
				case "mean":
					$label = "MÉDIA($campo)";
					$value = "MEAN($campo)";
					break;
				case "sum":
					$label = "SOMA($campo)";
					$value = "SUM($campo)";
					break;
				case "count":
					$label = "TOTAL($campo)";
					$value = "COUNT($campo)";
					break;
				case "": 
					$label = strtoupper($campo);
					$value = "$campo";
					break;
				default:
					$val = intval($mCampos[$i]);
					$label = "INTERVALO de $campo";
					$value = "CONCAT(FLOOR($campo/$val)*$val, ' a ', (1+FLOOR($campo/$val))*$val-1)";
					break;
			}
			$fields[$label] = "$value as `$label`";
		}
		
		// Define os grupos e ordenação do resultado da consulta
		$grupos = array();
		for ($i = 1; $i < count($linhas)+count($colunas)+1; $i++) $grupos[] = $i;
		
		// Define os parametros da query
		$campos = implode(', ', $fields);
		$tabela = Globals::get('tabela');
		$grupo = $grupos? "GROUP BY " . implode(', ', $grupos) : "";
		$ordem = $grupos? "ORDER BY " . implode(', ', $grupos) : "";
			
		// Retorna todos os registros
		echo $query = "SELECT $campos FROM $tabela $grupo $ordem";		
		$rows = Model::getAllRowsSQL($query);		
		
		/***********************************************************************/
				
		
		// Inicia a estrutura da Tabela
		echo "<table class='table table-stripped table-condensed'>";
		echo "	<thead>";
		echo "		<tr>";
				
		// Desenha o cabeçalho das linhas
		$rs = count($colunas) + 1;
		foreach ($cabecalho_linha as $cabecalho){
			echo "			<th rowspan='$rs'>$cabecalho</th>";
		}
		
		// Desenha os valores das colunas
		foreach ($rotulos_coluna as $i => $coluna){			
			for ($j = count($rotulos_coluna)-1, $cs = 1; $j > $i; $cs *= count($rotulos_coluna[$j--]));
			foreach ($rotulos_coluna[$i] as $rotulo)
				echo "			<th colspan='$cs'>$rotulo</th>";
			echo "		</tr>";			
		}
		
		echo "	</thead>";
		echo "	<tbody>";
		
		// Desenha os rotulos das linhas
		
		
		
		
		
		echo "	</tbody>";
		echo "</table>";
	
	}
	
	public function actionCertificado(){
		
		$emissao_inicio  = Globals::getDate('emissao_inicio');
		$emissao_fim     = Globals::getDate('emissao_fim');
		$validade_inicio = Globals::getDate('validade_inicio');
		$validade_fim    = Globals::getDate('validade_fim');
		$unidade_id =  Globals::get('unidade_id',
				Session::getUsuario()->hasPermission('gerencia', 'global')?
				NULL : Session::getUsuario('unidade_id') );
		
		$agrupa_unidade  = Globals::get('agrupa_unidade');
		$agrupa_tipo     = Globals::get('agrupa_tipo');
		$ordem           = Globals::get('ordem', 1);
		
		$emissao = $emissao_inicio? (
						$emissao_fim? "data_emissao BETWEEN '{$emissao_inicio}' AND '{$emissao_fim} 23:59:59'" :
						"data_emissao >= '{$emissao_inicio}'"
					) : ($emissao_fim? "data_emissao <= '{$emissao_fim} 23:59:59'" : "TRUE" );

		$validade = $validade_inicio? (
						$validade_fim? "data_validade BETWEEN '{$validade_inicio}' AND '{$validade_fim} 23:59:59'" :
						"data_validade >= '{$validade_inicio}'"
					) : ($validade_fim? "data_validade <= '{$validade_fim} 23:59:59'" : "TRUE" );

		$unidade = $unidade_id? "unidade_id = '$unidade_id'" : "TRUE";
		
		$grupos = array();
		if ($agrupa_unidade) $grupos[] = "unidade_id";
		if ($agrupa_tipo) $grupos[] = "tipo";
		$grupos = implode(",", $grupos);
		$grupos = $grupos? "GROUP BY $grupos" : ""; 
		
		$sql = "SELECT
				MAX(unidade_sigla) as unidade_sigla,
				MAX(tipo) as tipo,
				MAX(data_validade) as data_validade,
				MAX(data_emissao) as data_emissao,
				COUNT(certificado_id) as total
			FROM relatorio_certificado r								
			WHERE $unidade AND ($validade) AND ($emissao)
			$grupos
			ORDER BY $ordem";
		
		$this->rows = Model::getAllRowsSQL($sql);		
		$this->setView('certificado');
		return true;
	}
	
	public function actionFinanceiro(){
		
		$periodo_inicio = Globals::getDate('periodo_inicio');
		$periodo_fim    = Globals::getDate('periodo_fim');
		$canal    = Globals::getDate('canal');
		$unidade_id =  Globals::get('unidade_id',
				Session::getUsuario()->hasPermission('gerencia', 'global')?
				NULL : Session::getUsuario('unidade_id') );
		
		$agrupa_unidade  = Globals::get('agrupa_unidade');
		$agrupa_grupo    = Globals::get('agrupa_grupo');
		$agrupa_canal    = Globals::get('agrupa_canal');
		$ordem           = Globals::get('ordem', 1);
		
		$periodo = $periodo_inicio? (
				$periodo_fim? "data_emissao BETWEEN '{$periodo_inicio}' AND '{$periodo_fim} 23:59:59'" :
				"data_emissao >= '{$periodo_inicio}'"
		) : ($periodo_fim? "data_emissao <= '{$periodo_fim} 23:59:59'" : "TRUE" );
		
		$unidade = $unidade_id? "unidade_id = '$unidade_id'" : "TRUE";
		$canal = $canal? "canal = '$canal'" : "TRUE";
		
		$grupos = array();
		if ($agrupa_unidade) $grupos[] = "unidade_id";
		if ($agrupa_grupo) $grupos[] = "servico_grupo";
		if ($agrupa_canal) $grupos[] = "canal";
		$grupos = implode(",", $grupos);
		$grupos = $grupos? "GROUP BY $grupos" : "";
		
		$sql = "SELECT
					MAX(unidade_sigla) as unidade_sigla, MAX(servico_grupo) as servico_grupo, MAX(canal) as canal,
					SUM(valor_arrecadado) AS valor_arrecadado,
					SUM(valor_recolher) AS valor_recolher,
					SUM(valor_vencido) AS valor_vencido,
					SUM(valor_isento) AS valor_isento,
					SUM(
						valor_arrecadado+
						valor_recolher+
						valor_vencido+
						valor_isento
					) as total
				FROM relatorio_financeiro
				WHERE $unidade AND ($periodo) AND ($canal)
				$grupos
				ORDER BY $ordem";
		
		$this->rows = Model::getAllRowsSQL($sql);
		$this->setView('financeiro');
		return true;
	}
	
	public function actionAtribuicao(){

		$periodo_inicio = Globals::getDate('periodo_inicio');
		$periodo_fim    = Globals::getDate('periodo_fim');
		$unidade_id =  Globals::get('unidade_id',
				Session::getUsuario()->hasPermission('gerencia', 'global')?
				NULL : Session::getUsuario('unidade_id') );
		
		$agrupa_unidade   = Globals::get('agrupa_unidade');
		$agrupa_usuario   = Globals::get('agrupa_usuario');
		$agrupa_funcao    = Globals::get('agrupa_funcao');		
		$agrupa_status    = Globals::get('agrupa_status');
		
		$ordem            = Globals::get('ordem', 1);
		
		$periodo = $periodo_inicio? (
				$periodo_fim? "data_agendada BETWEEN '{$periodo_inicio}' AND '{$periodo_fim} 23:59:59'" :
				"data_agendada >= '{$periodo_inicio}'"
		) : ($periodo_fim? "data_agendada <= '{$periodo_fim} 23:59:59'" : "TRUE");
		
		$unidade = $unidade_id? "unidade_id = '$unidade_id'" : "TRUE";
		
		$grupos = array();
		if ($agrupa_unidade) $grupos[] = "unidade_sigla";
		if ($agrupa_usuario) $grupos[] = "usuario_nome";
		if ($agrupa_funcao) $grupos[] = "funcao_descricao";
		if ($agrupa_status) $grupos[] = "status";
		$grupos = implode(",", $grupos);
		$grupos = $grupos? "GROUP BY $grupos" : "";
		
		$sql = "SELECT
		MAX(unidade_sigla) as unidade_sigla,
		MAX(usuario_nome) as usuario_nome,
		MAX(funcao_descricao) as funcao_descricao,
		MAX(status) as status,
		COUNT(atribuicao_id) as total 
		FROM relatorio_atribuicao WHERE $unidade AND ($periodo) $grupos ORDER BY $ordem";
		
		$this->rows = Model::getAllRowsSQL($sql);
		$this->setView('atribuicao');
		return true;
	}
	
	public function actionSolicitacao(){
	
		$periodo_inicio = Globals::getDate('periodo_inicio');
		$periodo_fim    = Globals::getDate('periodo_fim');
		$canal    = Globals::get('canal');
		$unidade_id =  Globals::get('unidade_id',
				Session::getUsuario()->hasPermission('gerencia', 'global')?
				NULL : Session::getUsuario('unidade_id') );
	
		$agrupa_cidade    = Globals::get('agrupa_cidade');
		$agrupa_unidade   = Globals::get('agrupa_unidade');
		$agrupa_grupo     = Globals::get('agrupa_grupo');
		$agrupa_aprovacao = Globals::get('agrupa_aprovacao');
		$agrupa_pagamento = Globals::get('agrupa_pagamento');
		$agrupa_canal = Globals::get('agrupa_canal');
	
		$ordem            = Globals::get('ordem', "cidade");
		
		$periodo = $periodo_inicio? (
				$periodo_fim? "data_entrada BETWEEN '{$periodo_inicio}' AND '{$periodo_fim} 23:59:59'" :
				"data_entrada >= '{$periodo_inicio}'"
				) : ($periodo_fim? "data_entrada <= '{$periodo_fim} 23:59:59'" : "TRUE");
	
		$unidade = $unidade_id? "unidade_id = '$unidade_id'" : "TRUE";
		$canal = $canal? "canal = '$canal'" : "TRUE";
		
		$grupos = array();
		if ($agrupa_cidade) $grupos[] = "cidade";
		if ($agrupa_unidade) $grupos[] = "unidade_id";
		if ($agrupa_grupo) $grupos[] = "servico_grupo";
		if ($agrupa_pagamento) $grupos[] = "status_pagamento";
		if ($agrupa_aprovacao) $grupos[] = "status_aprovacao";
		if ($agrupa_canal) $grupos[] = "canal";
		
		$grupos = implode(",", $grupos);
		$grupos = $grupos? "GROUP BY $grupos" : "";

		$sql = "SELECT
			MAX(cidade) as cidade,
			MAX(unidade_sigla) as unidade_sigla,
			MAX(servico_grupo) as servico_grupo,
			MAX(status_pagamento) as status_pagamento,
			MAX(status_aprovacao) as status_aprovacao,
			MAX(canal) as canal,		
			COUNT(solicitacao_id) AS total		
		FROM relatorio_servico
		WHERE $unidade AND ($periodo) AND ($canal) AND canal IS NOT NULL
		$grupos
		ORDER BY $ordem";

		$this->rows = Model::getAllRowsSQL($sql);

		$this->setView('solicitacao');
		return true;
	}
	
	public function actionGrafico(){
		
		$unidade_id =  Globals::get('unidade_id',
				Session::getUsuario()->hasPermission('gerencia', 'global')?
				NULL : Session::getUsuario('unidade_id') );
		$inicio = Globals::getDate('periodo_inicio', "0000-01-01");
		$fim    = Globals::getDate('periodo_fim', "9999-12-31");
		
		$unidade = $unidade_id? "unidade_id = '$unidade_id'" : "TRUE";
		
		$this->graphs = array();
		
		$sql_certificado_tipo =
			"SELECT MAX(tipo) as Tipo, COUNT(certificado_id) as Total FROM relatorio_certificado
			WHERE
				$unidade AND 
				data_emissao BETWEEN '$inicio' AND '$fim 23:59:59'
			GROUP BY tipo ORDER BY 2";
		
		for ($rows = array(), Connection::query($sql_certificado_tipo); $row = Connection::next(); $rows[] = $row);
		foreach ($rows as &$row) $row['Tipo'] = Config::getTipoCertificado($row['Tipo']);
		$this->graphs[] = self::makeGraph("certificado-tipo", "Certificados por Tipo", "pie", $rows);
		
		$sql_certificado_mes = 
			"SELECT CONCAT(MONTHNAME(data_emissao),CONCAT('/',YEAR(data_emissao))) as `Mês`, COUNT(certificado_id) as Total FROM relatorio_certificado
				WHERE
				$unidade AND 
				data_emissao BETWEEN '$inicio' AND '$fim 23:59:59'
			GROUP BY 1 ORDER BY YEAR(MAX(data_emissao)), MONTH(MAX(data_emissao))";
		
		for ($rows = array(), Connection::query($sql_certificado_mes); $row = Connection::next(); $rows[] = $row);		
		$this->graphs[] = self::makeGraph("certificado-mes", "Certificados por Mês", "line", $rows);
		
		$sql_atribuicao_funcao = 
			"SELECT funcao_descricao as `Função`, count(atribuicao_id) as Total FROM relatorio_atribuicao
			WHERE
				$unidade AND 
				data_empenho BETWEEN '$inicio' AND '$fim 23:59:59'
			GROUP BY 1 ORDER BY 1";
		
		for ($rows = array(), Connection::query($sql_atribuicao_funcao); $row = Connection::next(); $rows[] = $row);
		$this->graphs[] = self::makeGraph("atribuicao-funcao", "Atribuições por Função", "bar", $rows);
		
		$sql_atribuicao_status = 
			"SELECT status as Status, count(atribuicao_id) as Total FROM relatorio_atribuicao
			WHERE
				$unidade AND
				data_empenho BETWEEN '$inicio' AND '$fim 23:59:59'
			GROUP BY 1 ORDER BY 1";
		
		for ($rows = array(), Connection::query($sql_atribuicao_status); $row = Connection::next(); $rows[] = $row);
		foreach ($rows as &$row) $row['Status'] = Config::getStatusAtribuicao($row['Status'], false);
		$this->graphs[] = self::makeGraph("atribuicao-status", "Atribuições por Status", "pie", $rows);
		
		$sql_atribuicao_mes =
			"SELECT CONCAT(MONTHNAME(data_empenho),CONCAT('/',YEAR(data_empenho))) as `Mês`, COUNT(atribuicao_id) as Total FROM relatorio_atribuicao
			WHERE
				$unidade AND
				data_empenho BETWEEN '$inicio' AND '$fim 23:59:59'
			GROUP BY 1 ORDER BY YEAR(MAX(data_empenho)), MONTH(MAX(data_empenho))";
		
		for ($rows = array(), Connection::query($sql_atribuicao_mes); $row = Connection::next(); $rows[] = $row);
		$this->graphs[] = self::makeGraph("atribuicao-mes", "Atribuições por Mês", "line", $rows);
		
		$sql_financeiro_grupo =
			"SELECT
				servico_grupo as `Serviço`,
				SUM(valor_arrecadado) AS `Valor Arrecadado`,
				SUM(valor_recolher) AS `Valor a Recolher`,
				SUM(valor_vencido) AS `Valor Vencido`,
				SUM(valor_isento) AS `Valor Isento`
			FROM relatorio_financeiro
			WHERE
				$unidade AND
				data_emissao BETWEEN '$inicio' AND '$fim 23:59:59'
			GROUP BY 1 ORDER BY 2 desc";
		
		for ($rows = array(), Connection::query($sql_financeiro_grupo); $row = Connection::next(); $rows[] = $row);
		foreach ($rows as &$row) $row['Serviço'] = Config::getGrupoServico($row['Serviço'], false);
		$this->graphs[] = self::makeGraph("financeiro-grupo", "Financeiro por Serviço", "bar", $rows);
		
		$sql_financeiro_status =
			"SELECT
				status_pagamento as Status,
				COUNT(*) as Total
			FROM relatorio_financeiro
			WHERE
				$unidade AND
				data_emissao BETWEEN '$inicio' AND '$fim 23:59:59'
			GROUP BY 1 ORDER BY 1";	
		
		for ($rows = array(), Connection::query($sql_financeiro_status); $row = Connection::next(); $rows[] = $row);
		foreach ($rows as &$row) $row['Status'] = Config::getStatusBoleto($row['Status'], false);
		$this->graphs[] = self::makeGraph("financeiro-status", "Financeiro por Pagamento", "pie", $rows);
		
		$sql_financeiro_mes =
			"SELECT
				CONCAT(MONTHNAME(data_emissao),CONCAT('/',YEAR(data_emissao))) as `Mês`,
				SUM(valor_arrecadado) AS `Valor Arrecadado`,
				SUM(valor_recolher) AS `Valor a Recolher`,
				SUM(valor_vencido) AS `Valor Vencido`,
				SUM(valor_isento) AS `Valor Isento`
			FROM relatorio_financeiro
			WHERE
				$unidade AND
				data_emissao BETWEEN '$inicio' AND '$fim 23:59:59'
			GROUP BY 1 ORDER BY YEAR(MAX(data_emissao)), MONTH(MAX(data_emissao))";
		
		for ($rows = array(), Connection::query($sql_financeiro_mes); $row = Connection::next(); $rows[] = $row);
		$this->graphs[] = self::makeGraph("financeiro-mes", "Financeiro por Mês", "line", $rows);
		
		$sql_servico_status =
			"SELECT status_aprovacao as Status, count(solicitacao_id) as Total FROM relatorio_servico
			WHERE
				$unidade AND
				data_entrada BETWEEN '$inicio' AND '$fim 23:59:59'
			GROUP BY 1 ORDER BY 1";
		
		for ($rows = array(), Connection::query($sql_servico_status); $row = Connection::next(); $rows[] = $row);
		foreach ($rows as &$row) $row['Status'] = Config::getStatusAprovacao($row['Status'], false);
		$this->graphs[] = self::makeGraph("servico-status", "Solicitações por Status", "pie", $rows);
		
		$sql_servico_grupo =
			"SELECT servico_grupo as `Serviço`, count(solicitacao_id) as Total FROM relatorio_servico
			WHERE
				$unidade AND
				data_entrada BETWEEN '$inicio' AND '$fim 23:59:59'
			GROUP BY 1 ORDER BY 1";

		for ($rows = array(), Connection::query($sql_servico_grupo); $row = Connection::next(); $rows[] = $row);
		foreach ($rows as &$row) $row['Serviço'] = Config::getGrupoServico($row['Serviço'], false);
		$this->graphs[] = self::makeGraph("servico-grupo", "Solicitações por Serviço", "bar", $rows);
		
		$sql_servico_mes =
			"SELECT CONCAT(MONTHNAME(data_entrada),CONCAT('/',YEAR(data_entrada))) as `Mês`, COUNT(solicitacao_id) as Total FROM relatorio_servico
			WHERE
				$unidade AND
				data_entrada BETWEEN '$inicio' AND '$fim 23:59:59'
			GROUP BY 1 ORDER BY YEAR(MAX(data_entrada)), MONTH(MAX(data_entrada))";
		
		for ($rows = array(), Connection::query($sql_servico_mes); $row = Connection::next(); $rows[] = $row);
		$this->graphs[] = self::makeGraph("servico-mes", "Solicitações por Mês", "line", $rows);
		
		$this->setView('grafico');
		return true;
		
	}
	
	private static function makeGraph($id = "", $title = "", $type = "bar", $rows = NULL, $options = ""){
		
		$rows = $rows? $rows : array(array(""));
		$columns = array_keys($rows[0]);
		
		$labels = array(); $series = array();		
		foreach ($columns as $i => $column){ 
			if ($i > 0) $series[$column] = array();
			foreach ($rows as $row)	{
				if ($i == 0)
					$labels[] = "'{$row[$column]}'";
				else
					$series[$column][] = $row[$column];			
			}								
		}
		
		$datasets = array();		
		foreach ($series as $label => $values){
			$data  = implode(",", $values);
			$colors = array();
			foreach ($values as $value) $colors[] = $color = sprintf("'#%06X'", rand(0, 0xFFFFFF));
			$colors = ($type == "bar")? $color : 
				( ($type == "line")? sprintf("\"rgba(%d, %d, %d, 0.2)\"", rand(0,255),rand(0,255),rand(0,255)): "[".implode(",", $colors)."]");
			$datasets[] = "{
					label: '$label',
					backgroundColor: $colors,
					fillColor: $colors,
					fill: true,
					data: [$data]
				}";
		}
	
		$labels = implode(",", $labels);
		$datasets = implode(",\n\t\t\t\t", $datasets);
		
		$data = "{
			labels: [$labels],
			datasets: [
				$datasets
			]		
		}";
		
		$js ="
			new Chart(
				document.getElementById('$id').getContext('2d'),
				{
					type: '$type',
					data: $data,
					options: { title: {text: '$title'}, $options }
				}
			);";
		
		return array("id"=>$id, "title"=>$title, "js"=>$js);
	}
	
}
