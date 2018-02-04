<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="pt-br">
	<head>
		<?php View::includeBlock("head"); ?>	
	</head>
	<body>
		<div class="container">			
			<?php View::includeBlock("menu-top") ?>
			<div class="row">
				<div class="col-md-12">
					<ol class="breadcrumb">					
						<li><a href="http://siga.bombeiros.pa.gov.br"><span class="glyphicon glyphicon-home"></span></a></li>
						<li><a href="<?php echo Controller::route("home", "default");?>">SISGAT</a></li>
						<li class="active">Mensagens</li>
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
					<div class="row form-group">
						<div class="col-md-12">
							<a class="btn btn-success form-control" href="<?php echo Controller::route("mensagem", "selecionar") ?>">
								<span class="glyphicon glyphicon-pencil"></span>
								Escrever Mensagem
							</a>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-12">
							<form id="form-busca" method="GET" action="<?php echo Controller::route("usuario", "mensagem")?>">
								<input type="hidden" id="status" name="status" value="<?= Globals::get('status')?>" />
								<div class="panel panel-warning">
									<div class="panel-heading">
										<span class="glyphicon glyphicon-filter"></span>
										Filtro de busca
									</div>
									<div class="panel-body">
										<div class="row form-group">
											<label class="col-md-12">Usuário:</label>
											<div class="col-md-12">
												<input class="form-control" value="<?php echo Globals::get('usuario')?>" type="text" name="usuario"/>
											</div>
											<label class="col-md-12">Assunto:</label>
											<div class="col-md-12">
												<input class="form-control" value="<?php echo Globals::get('assunto')?>" type="text" name="assunto"/>
											</div>
											<label for="cnpj_cpf" class="col-md-12">Data:</label>
											<div class="col-md-6">
												<input type="text" placeholder="início" class="date form-control" value="<?php echo Globals::get('data_envio1')?>" type="text" name="data_envio1"/>
											</div>
											<div class="col-md-6">
												<input type="text" placeholder="fim"  class="date form-control" value="<?php echo Globals::get('data_envio2')?>" type="text" name="data_envio2"/>						
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
						<?php if (count($this->mensagens) == 100):?> 
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
									<span class="glyphicon glyphicon-inbox"></span>
									Lista de Mensagens
								</div>
								<div class="panel-body">
									<ul class="nav nav-tabs">
									<?php foreach (Config::getStatusMensagem() as $status => $label):?>
						  				<li role="presentation" class="<?= ($status == Globals::get('status'))? 'active' : ''?>">
						  					<a class="change-status" data-status='<?= $status ?>' href='#'>
						  						<span class="<?= $status? '' : 'hidden' ?> quadro-legenda bg-<?php echo Config::getStatusMensagemClass($status)?>"></span>
						  						<?= $label ?>
						  					</a>
						  				</li>
					  				<?php endforeach; ?>	
									</ul>
									<div class="table-responsive" style="border: solid lightgray 1px; border-top: none">											
										<table class="table table-condensed">						
											<thead>
												<tr>
													<th>Data/Hora</th>
													<th>Usuário</th>
													<th>Assunto</th>
													<th class="text-center">Ações</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($this->mensagens as $mensagem):?>
												<tr class="<?php echo $mensagem->getStatusClass()?>">
													<td><?php echo $mensagem->getDataHoraEnvio()?></td>
													<td><?php echo $mensagem->getOrigem('nome')?></td>
													<td><?php echo $mensagem->get('assunto')?></td>
													<td class="text-center">
														<a href="#" style="" class="ler btn btn-info" data-href="<?php echo Controller::route("mensagem", "modal", $mensagem->get('id')) ?>">
															<span class="glyphicon glyphicon-eye-open"></span>
														</a>
													</td>
												</tr>
												<?php endforeach; ?>
											</tbody>			
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="modal-container"></div>
		</div>				
	</body>	
</html>
