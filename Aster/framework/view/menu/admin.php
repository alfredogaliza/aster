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
<ul class="nav navbar-nav navbar-right">
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-briefcase"></i>
			Administração
			<span class="caret"></span>
		</a>
		<ul class="dropdown-menu">	
			<?php if ($perm_vo) : ?><li><a href="<?= Controller::route('admin','voluntario') ?>"><span class="fa fa-users"></span> Voluntários</a></li><?php endif;?>
			<?php if ($perm_as) : ?><li><a href="<?= Controller::route('admin','assistido') ?>"><span class="fa fa-child"></span> Assistidos</a></li><?php endif; ?>
			<?php if ($perm_re) : ?><li><a href="<?= Controller::route('admin','responsavel') ?>"><span class="fa fa-vcard"></span> Responsáveis</a></li><?php endif; ?>
			
			<?php if ($perm_vo || $perm_as || $perm_re) :?><li role="separator" class="divider"></li><?php endif;?>
			
					
			<?php if ($perm_ac) : ?><li><a href="<?= Controller::route('admin','acao') ?>"><span class="fa fa-star"></span> Ações</a></li><?php endif; ?>
			<?php if ($perm_ev) : ?><li><a href="<?= Controller::route('admin','evento') ?>"><span class="fa fa-calendar"></span> Eventos</a></li><?php endif; ?>
			<?php if ($perm_ta) : ?><li><a href="<?= Controller::route('admin','tarefa') ?>"><span class="fa fa-th-list"></span> Tarefas</a></li><?php endif; ?>
			
			<?php if ($perm_ac || $perm_ev || $perm_ta) : ?><li role="separator" class="divider"></li><?php endif;?>
						
			<?php if ($perm_pe) : ?><li><a href="<?= Controller::route('admin','perfil') ?>"><span class="fa fa-id-badge"></span> Perfis</a></li><?php endif; ?>
			<?php if ($perm_no) : ?><li><a href="<?= Controller::route('admin','noticia') ?>"><span class="fa fa-newspaper-o"></span> Notícias</a></li><?php endif; ?>
			<?php if ($perm_rel) : ?><li><a href="<?= Controller::route('admin','relatorio') ?>"><span class="fa fa-line-chart"></span> Relatórios</a></li><?php endif; ?>					

		</ul>
	</li>
</ul>