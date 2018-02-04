<form action="<?php echo Controller::route("solicitacao", "buscar")?>" class="form" role="form">
	<div class="panel panel-default" id="menu-left" style="border: solid black 1px">
		<div class="panel-heading">
			Menu Principal
		</div>
		<div id="accordion">
			<div class="panel list-group" style="margin: 0px">
				<?php foreach (Session::getUsuario()->getMenus() as $menu):?>
				<div class="list-group-item" style="margin: -1px">
					<a data-toggle="collapse" data-parent="#accordion" href="#menu-left-<?= $menu->get('id')?>">
						<span class="<?php echo $menu->get('icone')?>"></span>
						<?php echo $menu->get('descricao')?>
					</a>
				</div>				 
				<div class="list-group collapse" id="menu-left-<?= $menu->get('id')?>"> 
					<?php foreach (Session::getUsuario()->getRecursos($menu) as $recurso): ?>
					<a class="list-group-item" href="<?php echo Controller::route($recurso->get('controle'), $recurso->get('acao')) ?>">
						<?php echo $recurso->get('descricao')?>
					</a>
					<?php endforeach; ?>
				</div>							
				<?php endforeach; ?>				
			</div>    		
		</div>		
	</div>
</form>