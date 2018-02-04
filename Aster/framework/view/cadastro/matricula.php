<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="pt-br">
	<head>
		<?php View::includeBlock("head"); ?>
		<script>
		$(function(){
			$("#polo").change(function(){
				$("#turma").load("<?= Controller::route('turma', 'options')?>/?polo_id="+$(this).val()+"&turma_id="+$("#turma").val());
			});
			$("#turma").load("<?= Controller::route('turma', 'options')?>/?polo_id=<?= Globals::get('polo_id', Session::getUsuario('polo_id'))?>&turma_id=<?= Globals::get('turma_id')?>");
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
						<li><a href="<?php echo Controller::route("home", "default");?>">GEPEV</a></li>
						<li class="active">Matrículas</li>
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
												<select id="polo" name="polo_id" class="form-control">
													<option value="">Todas as unidades</option>
													<?php echo Model::getOptions('polo', 'id', 'quartel', Globals::get('polo_id', Session::getUsuario('polo_id'))); ?>
												</select>
											<?php else: ?>
												<input type="hidden" name="polo_id" value="<?= Session::getUsuario('polo_id')?>" />
												<?= Session::getUsuario()->getPolo('quartel') ?>
											<?php endif; ?>	
											</div>									
											<label class="col-md-12">Turma:</label>
											<div class="col-md-12">
												<select id="turma" name="turma_id" class="form-control"></select>									
											</div>										
											<label for="login" class="col-md-12">Aluno: </label>
											<div class="col-md-12">
												<input type="text" name="aluno" value="<?= Globals::get('aluno') ?>" class="form-control" />
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
									Lista de Matriculas
								</div>
								<div class="panel-body">
									<ul class="nav nav-tabs">
									<?php foreach (Config::getStatusMatricula() as $status => $label):?>
						  				<li role="presentation" class="<?= ($status == Globals::get('status'))? 'active' : ''?>">
						  					<a class="change-status" data-status='<?= $status ?>' href='#'>
						  						<span  data-toggle="tooltip" data-title="<?= $label ?>" class="quadro-legenda bg-<?php echo Config::getStatusMatriculaClass($status)?>"></span>
						  						<span class="hidden-sm"><?= $label ?></span>
						  					</a>
						  				</li>
					  				<?php endforeach; ?>	
									</ul>
									<div class="table-responsive">
										<table class="table table-hover table-condensed" role="table">
											<thead>
												<tr>
													<th>Nome</th>
													<th>Polo<br>Turma</th>
													<th class="col-md-2 text-center">Ações</th>
												</tr>
											</thead>
											<tbody>
												<?php $editar = Session::getUsuario()->hasPermission('matricula', 'edit') ?>
												<?php $delete = Session::getUsuario()->hasPermission('matricula', 'delete') ?>
												<?php foreach ($this->matriculas as $matricula): ?>
												<tr class="bg-<?= Config::getStatusMatriculaClass($matricula['status'])?>">
													<td><?php echo $matricula['aluno_nome']?></td>
													<td><?php echo $matricula['polo_quartel']?><br><?php echo $matricula['turma_descricao']?></td>																		
													<td class="text-center" nowrap>
														<?php if ($editar):?>											
														<a data-toggle="tooltip" title= "Editar" class="edit btn btn-primary" data-href="<?php echo Controller::route('matricula', 'modal', $matricula['id']) ?>">
															<span class="fa fa-pencil"></span>
														</a><?php endif; if ($delete):?><a
															data-toggle="tooltip" title= "Excluir" class="delete async btn btn-danger" data-href="<?php echo Controller::route('matricula', 'delete', $matricula['id']) ?>">							
															<span class="fa fa-trash"></span>							
														</a>
														<?php endif; ?>
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