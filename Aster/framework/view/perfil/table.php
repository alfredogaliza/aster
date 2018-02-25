<div class="table-responsive">
	<table class="table table-condensed table-hover">
		<thead>
			<tr>
				<th>Descrição</th>
				<th class='text-center'>Ações</th>
			</tr>
		</thead>
		<tbody>									
		<?php if ($this->perfis): foreach ($this->perfis as $perfil): ?>
			<tr>
				<td><?= $perfil->get('descricao')?></td>				
				<td class='text-center'>
					<button class="btn btn-default edit" data-href="<?= Controller::route("perfil", "modal", $perfil->get('id')) ?>">
						<i class="fa fa-pencil"></i>
					</button>
					<a class="btn btn-default delete async" href="<?= Controller::route("perfil", "delete", $perfil->get('id')) ?>">
						<i class="fa fa-remove"></i>
					</a>
				</td>
			</tr>		
		<?php endforeach; else :?>
			<tr>
				<td colspan="3">Sem Registros</td>
			</tr>
		<?php endif;?>
		</tbody>
	</table>
</div>
