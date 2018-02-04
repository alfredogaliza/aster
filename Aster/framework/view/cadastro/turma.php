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
						<li><a href="<?php echo Controller::route("home", "default");?>">GEPEV</a></li>
						<li class="active">Turmas</li>
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
							<a data-href="<?php echo Controller::route('turma', 'modal')?>" class="edit btn btn-success form-control">							
								<span class="glyphicon glyphicon-plus"></span> Adicionar Turma							
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">			
							<form id="form-busca" method="GET" action="<?php echo Controller::route($this->name, $this->action)?>">
								<input type="hidden" name="status" id="status" value="<?= Globals::get('status') ?>" />
								<div class="panel panel-warning">
									<div class="panel-heading">
										<span class="glyphicon glyphicon-filter"></span>
										Filtro de busca
									</div>
									<div class="panel-body">
										<div class="row form-group">
											<label for="unidade_id" class="col-md-12">Polo: </label>					
											<div class="col-md-12">
											<?php if (Session::getUsuario()->hasPermission('gerencia', 'global')): ?>
												<select name="polo_id" class="form-control">
													<option value="">Todas as unidades</option>
													<?php echo Model::getOptions('polo', 'id', 'quartel', Globals::get('polo_id', Session::getUsuario('polo_id'))); ?>
												</select>
											<?php else: ?>
												<input type="hidden" name="polo_id" value="<?= Session::getUsuario('polo_id')?>" />
												<?= Session::getUsuario()->getPolo('quartel') ?>
											<?php endif; ?>	
											</div>											
											<label for="login" class="col-md-12">Descrição: </label>
											<div class="col-md-12">
												<input type="text" name="descricao" value="<?php echo Globals::get('descricao')?>" class="form-control" />
											</div>
											<label for="login" class="col-md-12">Observação: </label>
											<div class="col-md-12">
												<input type="text" name="observacao" value="<?php echo Globals::get('observacao')?>" class="form-control" />
											</div>
											<label class="col-md-12">Em curso no dia:</label>
											<div class="col-md-12">
												<input type="text" name="emcurso"  value="<?= Globals::get('emcurso') ?>" class="form-control date" />
											</div>
										</div>
										<div class="row form-group">
											<div class="col-md-12">
												<button type="submit" class="btn btn-primary form-control" id="btn-pesquisar">
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
									<span class="fa fa-graduation-cap"></span>
									Lista de Turmas
								</div>
								<div class="panel-body">
									<ul class="nav nav-tabs">
									<?php foreach (Config::getStatusTurma() as $status => $label):?>
						  				<li role="presentation" class="<?= ($status == Globals::get('status'))? 'active' : ''?>">
						  					<a class="change-status" data-status='<?= $status ?>' href='#'>
						  						<span  data-toggle="tooltip" data-title="<?= $label ?>" class="quadro-legenda bg-<?php echo Config::getStatusturmaClass($status)?>"></span>
						  						<span class="hidden-sm"><?= $label ?></span>
						  					</a>
						  				</li>
					  				<?php endforeach; ?>	
									</ul>
									<div class="table-responsive">
										<table class="table table-hover table-condensed" role="table">
											<thead>
												<tr>
													<th>Descrição<br>Observação</th>
													<th>Polo</th>
													<th>Coordenadores</th>
													<th>Início<br>Término</th>
													<th>Matrículas<br>Vagas</th>
													<th class="col-md-2 text-center">Ações</th>
												</tr>
											</thead>
											<tbody>												
												<?php foreach ($this->turmas as $turma): ?>
												<tr class="bg-<?= Config::getStatusTurmaClass($turma['status'])?>">
													<td><?php echo $turma['descricao']?><br><small><?php echo $turma['observacao']?></small></td>
													<td><?php echo $turma['polo_quartel']?></td>
													<td><div style="max-height:40px; max-width: 240px; overflow: auto"><?php echo $turma['coordenadores'] ?></div></td>
													<td><?php echo Config::toDateDMY($turma['inicio'])?><br><?php echo Config::toDateDMY($turma['termino'])?></td>
													<td><?php echo $turma['matriculas']?>/<?php echo $turma['vagas']?></td>					
													<td class="text-center" nowrap>										
														<a data-toggle="tooltip" title= "Editar" class="edit btn btn-primary" data-href="<?php echo Controller::route('turma', 'modal', $turma['id']) ?>">
															<span class="fa fa-pencil"></span>
														</a><a
															data-toggle="tooltip" title= "Excluir" class="delete async btn btn-danger" data-href="<?php echo Controller::route('turma', 'delete', $turma['id']) ?>">							
															<span class="fa fa-trash"></span>							
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
		</div>
	</body>	
</html>						