<div class="row form-group">
			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<a data-toggle="collapse" href="#administracao"> Administração <span class="pull-right"><i class="fa fa-briefcase"></i></span>
						</a>
					</div>
					<div class="panel-collapse collapse in" id="administracao">
						<div class="panel-body">
							<div class="row">
								<div class="col-md-4">
									<h4>Pessoas</h4>
									<div class="list-group">
										<a href="<?= Controller::route('admin','voluntario') ?>" class="list-group-item"><span class="fa fa-users fa-2x"></span> Voluntários</a> <a href="<?= Controller::route('admin','assitido') ?>" class="list-group-item"><span class="fa fa-child fa-2x"></span> Assistidos</a> <a href="<?= Controller::route('admin','responsavel') ?>" class="list-group-item"><span class="fa fa-vcard fa-2x"></span> Responsáveis</a>
									</div>
								</div>
								<div class="col-md-4">
									<h4>Instituto</h4>
									<div class="list-group">
										<a href="<?= Controller::route('admin','acao') ?>" class="list-group-item"><span class="fa fa-star fa-2x"></span> Ações</a> <a href="<?= Controller::route('admin','eveno') ?>" class="list-group-item"><span class="fa fa-calendar fa-2x"></span> Eventos</a> <a href="<?= Controller::route('admin','tarefa') ?>" class="list-group-item"><span class="fa fa-th-list fa-2x"></span> Tarefas</a>
									</div>
								</div>
								<div class="col-md-4">
									<h4>Sistema</h4>
									<div class="list-group">
										<a href="<?= Controller::route('admin','perfil') ?>" class="list-group-item"><span class="fa fa-id-badge fa-2x"></span> Perfis</a> <a href="<?= Controller::route('admin','noticia') ?>" class="list-group-item"><span class="fa fa-newspaper-o fa-2x"></span> Notícias</a> <a href="<?= Controller::route('admin','relatorio') ?>" class="list-group-item"><span class="fa fa-line-chart fa-2x"></span> Relatórios</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>