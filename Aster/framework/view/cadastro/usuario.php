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
						<li class="active">Usuários</li>
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
							<a data-href="<?php echo Controller::route('usuario', 'modal')?>" class="edit btn btn-success form-control">							
								<span class="glyphicon glyphicon-plus"></span> Adicionar Usuário							
							</a>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">			
							<form id="form-busca" method="GET" action="<?php echo Controller::route($this->name, $this->action)?>">
								<input type="hidden" id="status" name="status" value="<?= Globals::get('status')?>" />
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
											<label for="perfil_id" class="col-md-12">Perfil: </label>
											<div class="col-md-12">
												<select name="perfil_id" class="form-control">
													<option value="">Todos os perfis...</option>
													<?php echo Model::getOptions('perfil', 'id', 'descricao', $this->perfil_id); ?>
												</select>
											</div>
											<label for="login" class="col-md-12">Nome: </label>
											<div class="col-md-12">
												<input type="text" name="nome" value="<?php echo $this->nome?>" class="form-control" />
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
									<span class="glyphicon glyphicon-user"></span>
									Lista de Usuários
								</div>
								<div class="panel-body">
									<ul class="nav nav-tabs">
									<?php foreach (Config::getStatusUsuario() as $status => $label):?>
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
													<th>Nome<br>Perfil</th>
													<th>Login</th>
													<th>Polo</th>
													<th>Data de Login</th>
													<th class="col-md-2 text-center">Ações</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($this->usuarios as $usuario): ?>
												<tr class="bg-<?= Config::getStatusUsuarioClass($usuario['status'])?>">
													<td>
														<?php echo $usuario['nome']?><br>
														<small><?php echo $usuario['perfil_descricao']?></small>
													</td>
													<td><?php echo $usuario['login']?></td>
													<td><?php echo $usuario['polo_quartel']?></td>
													<td><?php echo Config::toDateDMY($usuario['ultimo_login'])?></td>					
													<td class="text-center" nowrap>
														<a href="#" class="edit btn btn-primary" data-href="<?php echo Controller::route('usuario', 'modal', $usuario['id']) ?>"><i class="fa fa-pencil"></i></a><button data-toggle="tooltip" title= "Resetar Senha" class="async btn btn-info" data-href="<?php echo Controller::route('usuario', 'reset', $usuario['id']) ?>">							
															<span class="glyphicon glyphicon-lock"></span>							
														</button><button data-toggle="tooltip" title= "<?php echo $usuario['bloqueado']? "Desbloquear" : "Bloquear" ?>" class="async btn btn-<?php echo $usuario['bloqueado']? "success" : "warning" ?>" data-href="<?php echo Controller::route('usuario', $usuario['bloqueado']? 'unblock':'block', $usuario['id']) ?>">							
															<span class="glyphicon glyphicon-<?php echo $usuario['bloqueado']? "ok-circle" :"ban-circle" ?>"></span>						
														</button><button data-toggle="tooltip" title= "Excluir" class="async confirm btn btn-danger" data-href="<?php echo Controller::route('usuario','exclude', $usuario['id']) ?>">							
															<span class="glyphicon glyphicon-trash"></span>						
														</button>					
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