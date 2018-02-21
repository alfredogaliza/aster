<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="pt-br">
	<head>
		<?php View::includeView("html/head"); ?>		
	</head>
	<body>
		<div class="container">
			<?php View::includeBlock("menu-top") ?>
			<div class="row">
				<div class="col-md-12">
					<ol class="breadcrumb">					
						<li><a href="http://siga.bombeiros.pa.gov.br"><span class="glyphicon glyphicon-home"></span></a></li>
						<li><a href="<?php echo Controller::route("home", "default");?>">SISGAT</a></li>
						<li class="active">Bairros</li>
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
							<a data-href="<?php echo Controller::route('bairro', 'modal')?>" class="edit btn btn-success form-control">							
								<span class="glyphicon glyphicon-plus"></span> Adicionar Bairro							
							</a>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-12">
							<form id="form-busca" method="GET" action="<?php echo Controller::route("admin", "bairro")?>">
								<div class="panel panel-warning">
									<div class="panel-heading">
										<span class="glyphicon glyphicon-filter"></span>
										Filtro de busca
									</div>
									<div class="panel-body">
										<div class="row form-group">
											<label for="cnpj_cpf" class="col-md-12">Cidade: </label>
											<div class="col-md-12">
												<select name="cidade_id" class="form-control">
													<option value="">Todos as cidades...</option>
													<?php echo Model::getOptions("cidade", "id", "nome", Globals::get('cidade_id')); ?>
												</select>
											</div>
											<label class="col-md-12">Bairro:</label>
											<div class="col-md-12">							
												<input type="text" class="form-control" name="nome" value="<?php echo Globals::get('nome') ?>" />
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
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-success">
								<div class="panel-heading">
									<span class="glyphicon glyphicon-star"></span>
									Lista de Bairros
								</div>
								<div class="table-responsive">			
									<table class="table table-hover table-condensed">
										<thead>
											<tr>
												<th>Cidade</th>
												<th>Bairro</th>
												<th class="text-center">Ações</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($this->bairros as $bairro): ?>
											<tr>
												<td><?php echo $bairro->get('cidade_nome')?></td>
												<td><?php echo $bairro->get('nome')?></td>
												<td class="text-center" nowrap>
													<a data-toggle="tooltip" title= "Editar" class="edit btn btn-info" data-href="<?php echo Controller::route('bairro', 'modal', $bairro->get('id')) ?>">							
														<span class="glyphicon glyphicon-pencil"></span>							
													</a><a data-toggle="tooltip" title= "Excluir" class="delete btn btn-danger" href="<?php echo Controller::route('bairro', 'delete', $bairro->get('id')) ?>">							
														<span class="glyphicon glyphicon-remove"></span>							
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
				</div>
			</div>		
			<div id="modal-container"></div>			
		</div>				
	</body>	
</html>