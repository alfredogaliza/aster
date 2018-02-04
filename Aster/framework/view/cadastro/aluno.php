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
						<li class="active">Alunos</li>
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
							<a data-href="<?php echo Controller::route('aluno', 'modal')?>" class="edit btn btn-success form-control">							
								<span class="glyphicon glyphicon-plus"></span> Adicionar Aluno							
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
													<?php echo Model::getOptions('polo', 'id', 'quartel', $this->polo_id); ?>
												</select>
											<?php else: ?>
												<input type="hidden" name="polo_id" value="<?= Session::getUsuario('polo_id')?>" />
												<?= Session::getUsuario()->getPolo('quartel') ?>
											<?php endif; ?>	
											</div>											
											<label for="login" class="col-md-12">Nome: </label>
											<div class="col-md-12">
												<input type="text" name="nome" value="<?php echo $this->nome?>" class="form-control" />
											</div>
											<label for="login" class="col-md-12">Responsável: </label>
											<div class="col-md-12">
												<input type="text" name="responsavel" value="<?php echo $this->responsavel?>" class="form-control" />
											</div>
											<label class="col-md-12">Inclusão:</label>
											<div class="col-md-6">
												<input type="text" name="inclusao1" id="inclusao1" data-end="#inclusao2" value="<?= Globals::get('inclusao1') ?>" class="form-control datetime start" />
											</div>
											<div class="col-md-6">
												<input type="text" name="inclusao2" id="inclusao2" data-start="#inclusao1" value="<?= Globals::get('inclusao2') ?>" class="form-control datetime end" />
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
									<span class="fa fa-users"></span>
									Lista de Alunos
								</div>
								<div class="panel-body">
									<ul class="nav nav-tabs">
									<?php foreach (Config::getStatusAluno() as $status => $label):?>
						  				<li role="presentation" class="<?= ($status == Globals::get('status'))? 'active' : ''?>">
						  					<a class="change-status" data-status='<?= $status ?>' href='#'>
						  						<span  data-toggle="tooltip" data-title="<?= $label ?>" class="quadro-legenda bg-<?php echo Config::getStatusAlunoClass($status)?>"></span>
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
													<th>Polo</th>
													<th>Responsáveis</th>
													<th>Inclusão</th>
													<th class="col-md-2 text-center">Ações</th>
												</tr>
											</thead>
											<tbody>
												<?php $editar = Session::getUsuario()->hasPermission('aluno', 'editar') ?>
												<?php $matricular = Session::getUsuario()->hasPermission('aluno', 'matricular') ?>
												<?php $historico = Session::getUsuario()->hasPermission('aluno', 'historico') ?>
												<?php $delete = Session::getUsuario()->hasPermission('aluno', 'delete') ?>
												<?php foreach ($this->alunos as $aluno): ?>
												<tr class="bg-<?= Config::getStatusAlunoClass($aluno['status'])?>">
													<td><?php echo $aluno['nome']?></td>
													<td><?php echo $aluno['polo_quartel']?></td>
													<td><?php echo str_replace(',', '<br>', $aluno['responsaveis']) ?></td>
													<td><?php echo Config::toDateDMY($aluno['inclusao'])?></td>					
													<td class="text-center" nowrap>
														<?php if ($editar):?>											
														<a data-toggle="tooltip" title= "Editar" class="edit btn btn-primary" data-href="<?php echo Controller::route('aluno', 'modal', $aluno['id']) ?>">
															<span class="fa fa-pencil"></span>
														</a><?php endif;  if ($matricular):?><a
															data-toggle="tooltip" title= "Matricular" class="edit btn btn-success" data-href="<?php echo Controller::route('aluno', 'matricular', $aluno['id']) ?>">
															<span class="fa fa-graduation-cap"></span>							
														</a><?php endif; if ($historico):?><a
															data-toggle="tooltip" title= "Histórico" class="btn btn-warning" data-href="<?php echo Controller::route('aluno', 'historico', $aluno['id']) ?>">							
															<span class="fa fa-file"></span>							
														</a><?php endif; if ($delete):?><a
															data-toggle="tooltip" title= "Excluir" class="delete async btn btn-danger" data-href="<?php echo Controller::route('aluno', 'delete', $aluno['id']) ?>">							
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