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
						<li class="active">Perfis</li>
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
							<a data-href="<?php echo Controller::route('perfil', 'modal')?>" class="edit btn btn-success form-control">							
								<span class="glyphicon glyphicon-plus"></span> Adicionar Perfil							
							</a>
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
									<span class="glyphicon glyphicon-th-list"></span>
									Lista de Perfis
								</div>		
								<div class="table-responsive">	
									<table class="table table-hover">										
										<thead>
											<tr>
												<th>Descrição</th>
												<th class="text-center" nowrap>Ações</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($this->perfis as $perfil): ?>
											<tr>
												<td><?php echo $perfil->get('descricao')?></td>					
												<td class="text-center">
													<a data-toggle="tooltip" title= "Editar" class="edit btn btn-info" data-href="<?php echo Controller::route('perfil', 'modal', $perfil->get('id')) ?>">							
														<span class="glyphicon glyphicon-pencil"></span>							
													</a><a data-toggle="tooltip" title= "Excluir" class="delete btn btn-danger" href="<?php echo Controller::route('perfil', 'delete', $perfil->get('id')) ?>">							
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