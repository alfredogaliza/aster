<?php
	$perm_vo = Session::getVoluntario()->hasPermission('admin', 'voluntario');
	$perm_as = Session::getVoluntario()->hasPermission('admin', 'assistido');
	$perm_re = Session::getVoluntario()->hasPermission('admin', 'responsavel');
	
	$perm_ac = Session::getVoluntario()->hasPermission('admin', 'acao');
	$perm_ev = Session::getVoluntario()->hasPermission('admin', 'evento');
	$perm_ta = Session::getVoluntario()->hasPermission('admin', 'tarefa');

	$perm_pe = Session::getVoluntario()->hasPermission('admin', 'perfil');
	$perm_no = Session::getVoluntario()->hasPermission('admin', 'noticia');
	$perm_rel = Session::getVoluntario()->hasPermission('admin', 'relatorio');	
?>

<?php if ($perm_vo || $perm_as || $perm_re || $perm_ac || $perm_ev || $perm_ta || $perm_pe || $perm_no || $perm_rel) :?>	
<div class="panel panel-info">
	<div class="panel-heading">
		<a data-toggle="collapse" href="#administracao"> Administração <span class="pull-right"><i class="fa fa-briefcase"></i></span>
		</a>
	</div>
	<div class="panel-collapse collapse" id="administracao">
		<div class="panel-body">
			<div class="row">
				<?php if ($perm_vo || $perm_as || $perm_re) :?>			
				<div class="col-md-12">
					<h4>Pessoas</h4>
					<div class="list-group">
						<?php if ($perm_vo) : ?><a href="<?= Controller::route('admin','voluntario') ?>" class="list-group-item"><span class="fa fa-users fa-2x"></span> Voluntários</a><?php endif;?>
						<?php if ($perm_as) : ?><a href="<?= Controller::route('admin','assistido') ?>" class="list-group-item"><span class="fa fa-child fa-2x"></span> Assistidos</a><?php endif; ?>
						<?php if ($perm_re) : ?><a href="<?= Controller::route('admin','responsavel') ?>" class="list-group-item"><span class="fa fa-vcard fa-2x"></span> Responsáveis</a><?php endif; ?>
					</div>
				</div>
				<?php endif; ?>
				<?php if ($perm_ac || $perm_ev || $perm_ta) : ?>
				<div class="col-md-12">
					<h4>Instituto</h4>
					<div class="list-group">
						<?php if ($perm_ac) : ?><a href="<?= Controller::route('admin','acao') ?>" class="list-group-item"><span class="fa fa-star fa-2x"></span> Ações</a><?php endif; ?>
						<?php if ($perm_ev) : ?><a href="<?= Controller::route('admin','evento') ?>" class="list-group-item"><span class="fa fa-calendar fa-2x"></span> Eventos</a><?php endif; ?>
						<?php if ($perm_ta) : ?><a href="<?= Controller::route('admin','tarefa') ?>" class="list-group-item"><span class="fa fa-th-list fa-2x"></span> Tarefas</a><?php endif; ?>
					</div>
				</div>
				<?php endif; ?>
				<?php if ($perm_pe || $perm_no || $perm_rel) : ?>
				<div class="col-md-12">
					<h4>Sistema</h4>
					<div class="list-group">
						<?php if ($perm_pe) : ?><a href="<?= Controller::route('admin','perfil') ?>" class="list-group-item"><span class="fa fa-id-badge fa-2x"></span> Perfis</a><?php endif; ?>
						<?php if ($perm_no) : ?><a href="<?= Controller::route('admin','noticia') ?>" class="list-group-item"><span class="fa fa-newspaper-o fa-2x"></span> Notícias</a><?php endif; ?>
						<?php if ($perm_rel) : ?><a href="<?= Controller::route('admin','relatorio') ?>" class="list-group-item"><span class="fa fa-line-chart fa-2x"></span> Relatórios</a><?php endif; ?>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>