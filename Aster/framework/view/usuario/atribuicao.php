<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="pt-br">
	<head>
		<?php View::includeBlock("head"); ?>
		<script>
			$(document).ready(function(){
				$('.change-status').click(function(event){
					event.preventDefault();
					$('#status').val($(this).attr('data-status'));
					$('#form-busca').submit();
					return false;
				});	
				$(".edit").click(function(){
					var href = $(this).attr("data-href");
					$("#modal-container").load(href);
				});				
				$("#form-busca select").change(function(){
					$("#form-busca").submit();
				});
				$('[data-toggle="tooltip"]').tooltip();		
			});
		</script>		
	</head>
	<body>
		<div class="container">			
			<?php View::includeBlock("menu-top") ?>
			<div class="row">
				<div class="col-md-12">
					<ol class="breadcrumb">					
						<li><a href="http://siga.bombeiros.pa.gov.br"><span class="glyphicon glyphicon-home"></span></a></li>
						<li><a href="<?php echo Controller::route("home", "default");?>">SISGAT</a></li>
						<li class="active">Atribuições de <?php echo Session::getUsuario('nome')?></li>
					</ol>
				</div>
			</div>
			<div class="row">
				<div class="col-md-3">
					<div class="row">
						<div class="col-md-12">
							<?php View::includeBlock("menu-left") ?>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<form id="form-busca" method="GET" action="<?php echo Controller::route("usuario", "atribuicao")?>">
								<div class="panel panel-warning">
									<div class="panel-heading">
										<span class="glyphicon glyphicon-filter"></span>
										Filtro de busca
									</div>
									<div class="panel-body">
										<div class="row form-group">
											<label for="cnpj_cpf" class="col-md-12">Protocolo:</label>
											<div class="col-md-12">
												<input class="form-control" value="<?php echo $this->solicitacao_id?>" type="text" name="solicitacao_id"/>
											</div>
											<label class="col-md-12">Função: </label>
											<div class="col-md-12">
												<select name="funcao_id" class="form-control">
													<option value="0">Todos as Funções</option>
													<?php echo Model::getOptions('funcao', 'id', 'descricao', $this->funcao_id); ?>
												</select>
											</div>									
										</div>
										<div class="row form-group">
											<label class="col-md-12">Agendamento: </label>					
											<div class="col-md-6">
												<input placeholder="início" type="text" class="date form-control" name="data_agendada1" value="<?php echo preg_replace("#(\d+)-(\d+)-(\d+)#", "$3/$2/$1", $this->data_agendada1)?>" />
											</div>
											<div class="col-md-6">
												<input placeholder="fim"  type="text" class="date form-control" name="data_agendada2" value="<?php echo preg_replace("#(\d+)-(\d+)-(\d+)#", "$3/$2/$1", $this->data_agendada2)?>" />
											</div>
										</div>
										<div class="row form-group">
											<label class="col-md-12">Execução: </label>					
											<div class="col-md-6">
												<input placeholder="início" type="text" class="date form-control" name="data_execucao1" value="<?php echo preg_replace("#(\d+)-(\d+)-(\d+)#", "$3/$2/$1", $this->data_execucao1)?>" />
											</div>
											<div class="col-md-6">
												<input placeholder="fim"  type="text" class="date form-control" name="data_execucao2" value="<?php echo preg_replace("#(\d+)-(\d+)-(\d+)#", "$3/$2/$1", $this->data_execucao2)?>" />
											</div>
										</div>
										<div class="row form-group">
											<div class="col-md-12">
												<button type="submit" class="btn btn-primary form-control" >
													<span class="glyphicon glyphicon-search"></span>
													Buscar
												</button>
											</div>
										</div>
									</div>
									<input type="hidden" id="status" name="status" value="<?= Globals::get('status')?>" />
								</div>				
							</form>
						</div>
					</div>
				</div>
				<div class="col-md-9">
					<div class="row">
						<?php if ($this->msg == 'success'):?>
						<div class="col-md-12">
							<div class="alert alert-info fade in">
								Operação realizada com sucesso!
								<a href="#" class="close" data-dismiss="alert">&times;</a>
							</div>
						</div>
						<?php else : if ($this->msg == 'fail'): ?>
						<div class="col-md-12">
							<div class="alert alert-danger fade in">
								Falha na operação!
								<a href="#" class="close" data-dismiss="alert">&times;</a>
							</div>
						</div>
						<?php endif; endif; ?>
						<?php if (count($this->atribuicoes) == 100):?> 
						<div class="col-md-12">
							<div class="alert alert-warning fade in">
								Resultados omitidos. Refine sua pesquisa.
								<a href="#" class="close" data-dismiss="alert">&times;</a>
							</div>
						</div>
						<?php endif; ?>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-success">
								<div class="panel-heading">
									<span class="glyphicon glyphicon-star"></span>
									Atribuições de <?php echo Session::getUsuario('nome')?>
								</div>
								<div class="panel-body">
									<ul class="nav nav-tabs">
									<?php foreach (Config::getStatusAtribuicao() as $status => $label):?>
						  				<li role="presentation" class="<?= ($status == Globals::get('status'))? 'active' : ''?>">
						  					<a class="change-status" data-status='<?= $status ?>' href='#'>
						  						<span class="<?= $status? '' : 'hidden' ?> quadro-legenda bg-<?php echo Config::getStatusAtribuicaoClass($status)?>"></span>
						  						<?= $label ?>
							  					</a>
							  				</li>
						  				<?php endforeach; ?>	
									</ul>
									<div class="table-responsive" style="border: solid lightgray 1px; border-top: none">
									<table class="table table-hover table-condensed">
										<thead>
											<tr>						
												<th>Protocolo</th>
												<th>Função</th>
												<th>Data Agendada</th>
												<th>Data Execução</th>
												<th class="text-center">Ações</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($this->atribuicoes as $atribuicao): ?>
											<tr class=" alert alert-<?php echo Config::getStatusAtribuicaoClass($atribuicao['status'])?>">
												<td><?php echo $atribuicao['solicitacao_id']?></td>						
												<td><?php echo $atribuicao['funcao_descricao']?></td>		
												<td><?php echo Config::toDateDMY($atribuicao['data_agendada'])?></td>
												<td><?php echo Config::toDateDMY($atribuicao['data_execucao'])?></td>					
												<td class="text-center" nowrap>
													<a target="_blank" data-toggle="tooltip" title= "Solicitação" class="btn btn-info" href="<?php echo Controller::route('solicitacao', 'info', $atribuicao['solicitacao_id']) ?>">							
														<span class="glyphicon glyphicon-info-sign"></span>							
													</a><?php if ($atribuicao['status'] == Config::STATUS_ATRIBUICAO_PENDENTE || $atribuicao['status'] == Config::STATUS_ATRIBUICAO_ATRASADO):?><a data-toggle="tooltip" title="Lançar Exigências" class="btn btn-success" href="<?php echo Controller::route('exigencia', 'form', $atribuicao['id']) ?>">							
														<span class="glyphicon glyphicon-check"></span>							
													</a><?php endif; ?><a data-toggle="tooltip" title="Imprimir Ficha" class="btn btn-warning" target="_blank" href="<?php echo Controller::route('exigencia', 'imprimir', $atribuicao['id']) ?>">							
														<span class="glyphicon glyphicon-print"></span>							
													</a>														
												</td>
											</tr>
											<?php endforeach;?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>						
				<div id="modal-container"></div>
			</div>
				</div>
			</div>
		</div>				
	</body>	
</html>
